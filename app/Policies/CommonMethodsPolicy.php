<?php

namespace App\Policies;

class CommonMethodsPolicy
{
    protected function findAccessNameRoles(array $accessNameRoles, $user) {
        $nameRoles = $user->roles()->pluck('name');

        foreach ($nameRoles as $nameRole) {
            foreach ($accessNameRoles as $accessNameRole) {
                if ($accessNameRole == $nameRole) {
                    return true;
                }
            }
        }

        return false;
    }
}