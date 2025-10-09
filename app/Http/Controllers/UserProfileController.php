<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    use FileUploadTrait;

    function update(Request $request) {
        // Règles de validation
        $rules = [
            'avatar' => ['nullable', 'image', 'max:500'],
            'name' => ['required', 'string', 'max:50'],
            'user_id' => ['required', 'string', 'max:50', 'unique:users,user_name,'.auth()->id()],
            'email' => ['required', 'email', 'max:100', 'unique:users,email,'.auth()->id()]
        ];

        // Messages de validation personnalisés
        $messages = [
            'avatar.image' => __('profile.validation.avatar.image'),
            'avatar.max' => __('profile.validation.avatar.max', ['max' => 500]),
            'name.required' => __('profile.validation.name.required'),
            'name.string' => __('profile.validation.name.string'),
            'name.max' => __('profile.validation.name.max', ['max' => 50]),
            'user_id.required' => __('profile.validation.user_id.required'),
            'user_id.string' => __('profile.validation.user_id.string'),
            'user_id.max' => __('profile.validation.user_id.max', ['max' => 50]),
            'user_id.unique' => __('profile.validation.user_id.unique'),
            'email.required' => __('profile.validation.email.required'),
            'email.email' => __('profile.validation.email.email'),
            'email.max' => __('profile.validation.email.max', ['max' => 100]),
            'email.unique' => __('profile.validation.email.unique'),
        ];

        // Validation initiale
        $validatedData = $request->validate($rules, $messages);

        // Traitement de l'avatar
        $validatedData['avatar'] = $this->uploadFile($request, 'avatar');

        // Mise à jour de l'utilisateur
        $user = Auth::user();
        
        if (!empty($validatedData['avatar'])) {
            $user->avatar = $validatedData['avatar'];
        }
        
        $user->name = $validatedData['name'];
        $user->user_name = $validatedData['user_id'];
        $user->email = $validatedData['email'];

        // Gestion du mot de passe si fourni
        if ($request->filled('current_password')) {
            $passwordRules = [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ];

            $passwordMessages = [
                'current_password.required' => __('profile.validation.current_password.required'),
                'current_password.current_password' => __('profile.validation.current_password.current_password'),
                'password.required' => __('profile.validation.password.required'),
                'password.string' => __('profile.validation.password.string'),
                'password.min' => __('profile.validation.password.min', ['min' => 8]),
                'password.confirmed' => __('profile.validation.password.confirmed'),
            ];

            $request->validate($passwordRules, $passwordMessages);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Message de succès
        $successMessage = $request->filled('current_password') 
            ? __('profile.success.password_updated') 
            : __('profile.success.profile_saved');

        notyf()->addSuccess($successMessage);

        return response(['message' => $successMessage], 200);

    }
}
