<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\UserService;


class UserController extends Controller
{
    protected UserService $userService;
    protected $base_route = 'admin.users';
    protected $panel_name = 'User';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index()
    {
        $users = $this->userService->listUsers();
        return view($this->base_route.'.index', compact('users'));
    }


    public function create()
    {
        return view($this->base_route.'.create');
    }


    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->validated());

        return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' added successfully.');
    }


    public function show(User $user)
    {
        return view($this->base_route.'.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view($this->base_route.'.edit', compact('user'));
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->updateUser($user, $request->validated());

        return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' updated successfully.');
    }


    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user);
            return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route($this->base_route.'.index')->with('error', $e->getMessage());
        }
    }

}
