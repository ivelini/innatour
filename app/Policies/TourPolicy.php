<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tour;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourPolicy extends CommonMethodsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tours.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $accessNameRoles = ['admin', 'manager'];
        $access = $this->findAccessNameRoles($accessNameRoles, $user);

        return $access;
    }
}
