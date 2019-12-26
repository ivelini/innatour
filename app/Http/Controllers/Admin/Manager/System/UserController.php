<?php

namespace App\Http\Controllers\Admin\Manager\System;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        $users = $this->userRepository->startConditions()
            ->with('roles')
            ->get();

        $roles = Role::all();

        return view('admin.page.manager.system.users', compact('users', 'roles'));
    }

    public function changeRole(Request $request, $id)
    {
        $roleId = $request->input('role');
        $user = $this->userRepository->getEdit($id);

        if(empty($user->roles) == false) {
            $user->roles()->sync([$roleId]);
        } else {
            if($user->roles->first()->name == 'admin') {
                return redirect()
                    ->route('manager.system.users')
                    ->withErrors('Пользователя с ролью "Администратор" изменить нельзя');
            } else {
                if ($roleId == 000) {
                    $user->roles()->detach();
                } else {
                    $user->roles()->sync([$roleId]);
                }
            }
        }

        return redirect()
            ->route('manager.system.users')
            ->with(['success' => 'Роль пользователя изменена']);
    }

    public function destroy($id)
    {
        $user = $this->userRepository->getEdit($id);

        if($user->roles->first()->name == 'admin') {
            return redirect()
                ->route('manager.system.users')
                ->withErrors('Пользователя с ролью "Администратор" удалить нельзя');
        }
        else {
            $user->delete();
        }

        return redirect()
            ->route('manager.system.users')
            ->with(['success' => 'Пользователь удален']);
    }
}
