<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Categorie;
use App\Models\Canton;
use App\Models\Ville;

class UserVisibilityService
{
    public function getVisibleUsers(Collection $users, string $viewerCountry): Collection
    {
        $tabNoAvatar = collect();
        $tabPause = collect();
        $tabBest = collect();

        $users
            ->filter(fn($user) => $user->isProfileVisibleTo($viewerCountry))
            ->each(function ($user) use (&$tabNoAvatar, &$tabPause, &$tabBest) {
                // Enrichir les données
                $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
                $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
                $user->canton = Canton::find($user->canton);
                $user->ville = Ville::find($user->ville);

                Log::info("User ID {$user->id} - Rate Activity: {$user->rate_activity}");

                // Organisation par catégorie
                if (empty($user->avatar)) {
                    $tabNoAvatar->push($user);
                } elseif ($user->is_profil_pause) {
                    $tabPause->push($user);
                } else {
                    $tabBest->push($user);
                }
            });

        // Tri des tableaux
        $tabBest = $this->sortUsers($tabBest);
        $tabPause = $this->sortUsers($tabPause);
        $tabNoAvatar = $this->sortNoAvatarUsers($tabNoAvatar);

        // Fusion finale
        return $tabBest->concat($tabNoAvatar)->concat($tabPause);
    }

    private function sortUsers(Collection $users): Collection
    {
        return $users->sortByDesc('rate_activity')
                     ->sortByDesc(fn($user) => strtotime($user->last_activity))
                     ->values();
    }

    private function sortNoAvatarUsers(Collection $users): Collection
    {
        return $users->sortBy(fn($user) => $user->is_profil_pause ? 0 : 1)
                     ->sortByDesc('rate_activity')
                     ->sortByDesc(fn($user) => strtotime($user->last_activity))
                     ->values();
    }
}
