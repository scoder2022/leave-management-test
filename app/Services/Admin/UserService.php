<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function listUsers(): LengthAwarePaginator
    {
        $users = User::where('role','employee')->latest()->paginate(10);
        return $users;
    }


    public function createUser(array $data): User
    {
        return User::create($data);
    }


    public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }


    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
    
}
