<?php

namespace App\Repositories;

use App\Models\Post;

use App\Traits\FileStorageTrait;
use Carbon\Carbon;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use StaticArray;

class PostRepository implements PostRepositoryInterface
{
    use FileStorageTrait;

    const STORE_POST_IMAGE_PATH = "public/post/images/";

    protected $post, $settingRepository;

    public function __construct(Post $post, SettingRepositoryInterface $settingRepository)
    {
        $this->post = $post;
        $this->settingRepository = $settingRepository;
    }

    public function getAll(Request $request)
    {
        $loggedInUserId = auth()->id();
        $paginationLimit = StaticArray::$paginationLimit;

        $searchUser = $request->input('searchUser');
        $searchDescription = $request->input('searchDescription');

        $query = $this->post::with([
            'user',
            'comment',
            'postLike' => function ($query) use ($loggedInUserId) {
                $query->where('user_id', $loggedInUserId);
            },
            'comment.user'
        ])->orderByDesc('created_at');


        if ($searchUser) {
            $query->whereHas('user', function ($query) use ($searchUser) {
                $query->where('name', 'like', "%$searchUser%")
                    ->orWhere('lastName', 'like', "%$searchUser%");
            });
        }

        if ($searchDescription) {
            $query->where('description', 'like', "%{$searchDescription}%");
        }

        return $query->paginate($paginationLimit);
    }

    public function find($id)
    {
        return $this->post->find($id);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->id();
        if (isset($data['media'])) {
            $data['media'] = $this->getStorePathFromFile($data['media'], self::STORE_POST_IMAGE_PATH);
        }
        
        $data['visibility'] = 0;

        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        if (isset($data['media'])) {
            $data['media'] = $this->getStorePathFromFile($data['media'], self::STORE_POST_IMAGE_PATH);
        }
        return $this->post->where('id', $id)->update($data);
    }

    public function delete($post)
    {
        return $post->delete();
    }

    public function getAllCount()
    {
        return $this->post::get()->count();
    }

    public function getCurrentDayPosts()
    {
        $today = Carbon::today();
        return $this->post::whereDate('created_at', $today)
            ->where('user_id', auth()->id())
            ->get()->count();
    }

    public function canPostToday()
    {
        $currentDayPosts = $this->getCurrentDayPosts();
        $currentDayMaxPosts = $this->settingRepository->getCurrentDayMaxPosts();

        if ($currentDayPosts >= $currentDayMaxPosts) {
            return false;
        }
        return true;
    }
}
