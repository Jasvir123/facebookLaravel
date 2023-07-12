<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\FileStorageTrait;
use Illuminate\Http\Request;
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

    public function getUsersWithRoleUser()
    {
        return Role::where('name', 'user')->first()->users();
    }

    public function getAll(Request $request)
    {

        $orderByArray = [];

        if ($request->filled('sortEmail')) {
            if ($request->sortEmail == 'desc') {
                $orderByArray['email'] = 'asc';
            } else {
                $orderByArray['email'] = 'desc';
            }
        }

        if ($request->filled('sortUser')) {
            if ($request->sortUser == 'desc') {
                $orderByArray['name'] = 'asc';
            } else {
                $orderByArray['name'] = 'desc';
            }
        }

        $paginationLimit = Config::get('pagination.limit');
        $query = $this->getUsersWithRoleUser();

        foreach ($orderByArray as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $searchName = $request->input('searchName');
        $searchEmail = $request->input('searchEmail');

        if ($searchName) {
            $query->where(function ($query) use ($searchName) {
                $query->where('name', 'like', "%$searchName%");
                $query->orWhere('lastName', 'like', "%$searchName%");
            });
        }

        if ($searchEmail) {
            $query->where('email', 'like', "%$searchEmail%");
        }

        return $query->paginate($paginationLimit)->withQueryString();
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function create($data)
    {
        if (isset($data['profileImage'])) {
            $data['profileImage'] = $this->getStorePathFromFile($data['profileImage'], self::STORE_PROFILE_IMAGE_PATH);
        }

        $createdUser = $this->user->create($data);

        $role = Role::findByName('user', 'web');
        $createdUser->assignRole($role);

        return $createdUser;
    }

    public function update($id, $data)
    {
        if (isset($data['profileImage'])) {
            $data['profileImage'] = $this->getStorePathFromFile($data['profileImage'], self::STORE_PROFILE_IMAGE_PATH);
        }

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
