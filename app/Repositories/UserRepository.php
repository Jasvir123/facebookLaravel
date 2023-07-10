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

    public function getAll()
    {
        $paginationLimit = Config::get('pagination.limit');
        return Role::where('name', 'user')->first()->users()->orderByDesc('created_at')->paginate($paginationLimit);
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
