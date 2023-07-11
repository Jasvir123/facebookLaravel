<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\FileStorageTrait;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    use FileStorageTrait;

    protected $user;

    const STORE_PROFILE_IMAGE_PATH = "public/profile/images";

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsersWithRoleUser() {
        return Role::where('name', 'user')->first()->users();
    }

    public function getAll()
    {
        $paginationLimit = Config::get('pagination.limit');
        return $this->getUsersWithRoleUser()->orderByDesc('created_at')->paginate($paginationLimit);
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function create($data)
    {
        $data['profileImage'] = $this->getStorePathFromFile($data['profileImage'], self::STORE_PROFILE_IMAGE_PATH);

        $createdUser = $this->user->create($data);

        $role = Role::findByName('user', 'web');
        $createdUser->assignRole($role);

        return $createdUser;
    }

    public function update($id, $data)
    {
        $data['profileImage'] = $this->getStorePathFromFile($data['profileImage'], self::STORE_PROFILE_IMAGE_PATH);

        return $this->user->where('id', $id)->update($data);
    }

    public function delete($user)
    {
        return $user->delete();
    }

    public function getAllCount()
    {
        return $this->getUsersWithRoleUser()->get()->count();
    }

    public function getAllActiveCount()
    {
        return $this->getUsersWithRoleUser()->where('isActive', '1')->count();
    }

    public function userIsActiveToggle(User $user)
    {
        $user->isActive = !$user->isActive;
        $user->save();
    }
}
