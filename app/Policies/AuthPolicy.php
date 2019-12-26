<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AuthPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function authManager($user)
    {
        $accessNameRoles = ['admin', 'manager'];

        return $this->searchRole($accessNameRoles, $user);

    }

    public function authAdmin($user)
    {
        $accessNameRoles = ['admin'];

        return $this->searchRole($accessNameRoles, $user);
    }

    protected function searchRole(array $accessNameRoles, $user)
    {
        $userRoles = $user->roles()->pluck('name');

        foreach ($userRoles as $nameRole) {
            foreach ($accessNameRoles as $accessNameRole) {
                if ($accessNameRole == $nameRole) {
                    return true;
                }
            }
        }

        return false;
    }
}