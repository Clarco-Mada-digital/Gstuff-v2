<div class="bg-white shadow rounded-lg p-6">
  <div class="grid grid-cols-1 gap-6">
      <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
          <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
          <label for="password" class="block text-sm font-medium text-gray-700">
              {{ isset($user) ? 'Nouveau mot de passe' : 'Mot de passe' }}
          </label>
          <input type="password" name="password" id="password"
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
              Confirmer le mot de passe
          </label>
          <input type="password" name="password_confirmation" id="password_confirmation"
                 class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
          <label class="block text-sm font-medium text-gray-700">Rôles</label>
          <div class="mt-2 space-y-2">
              @foreach($roles as $role)
              <div class="flex items-center">
                  <input type="checkbox" name="roles[]" id="role-{{ $role->id }}" value="{{ $role->id }}"
                         class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                         {{ (isset($user) && $user->hasRole($role->name)) ? 'checked' : '' }}>
                  <label for="role-{{ $role->id }}" class="ml-3 block text-sm font-medium text-gray-700">
                      {{ $role->name }}
                  </label>
              </div>
              @endforeach
          </div>
      </div>
  </div>
</div>