<?php

declare(strict_types=1);

namespace App\Policies;

use App\Profile;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any profiles.
     *
     * @return mixed
     */
    public function viewAny(User $user) {}

    /**
     * Determine whether the user can view the profile.
     *
     * @return mixed
     */
    public function view(User $user, Profile $profile) {}

    /**
     * Determine whether the user can create profiles.
     *
     * @return mixed
     */
    public function create(User $user) {}

    /**
     * Determine whether the user can update the profile.
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine whether the user can delete the profile.
     *
     * @return mixed
     */
    public function delete(User $user, Profile $profile) {}

    /**
     * Determine whether the user can restore the profile.
     *
     * @return mixed
     */
    public function restore(User $user, Profile $profile) {}

    /**
     * Determine whether the user can permanently delete the profile.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Profile $profile) {}
}
