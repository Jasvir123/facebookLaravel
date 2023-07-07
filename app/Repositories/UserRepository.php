<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return Role::where('name', 'user')->first()->users()->get();
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function create($data)
    {
        return $this->user->create($data);
    }

    public function update($id, $data)
    {
        return $this->user->where('id', $id)->update($data);
    }

    public function delete($user)
    {
        return $user->delete();
    }

    public function getAllCount()
    {
        return $this->getAll()->count();
    }

    public function getAllActiveCount()
    {
        return Role::where('name', 'user')->first()
            ->users()->where('isActive', '1')->count();
    }

    public function userIsActiveToggle(User $user)
    {
        $user->isActive = !$user->isActive;
        $user->save();
    }
}
