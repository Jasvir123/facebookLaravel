<?php

namespace App\Repositories;

use App\Models\Post;

use App\Traits\FileStorageTrait;
use Carbon\Carbon;
use App\Repositories\SettingRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    use FileStorageTrait;

    const STORE_POST_IMAGE_PATH = "public/post/images";

    protected $post, $settingRepository;

    public function __construct(Post $post, SettingRepositoryInterface $settingRepository)
    {
        $this->post = $post;
        $this->settingRepository = $settingRepository;
    }

    public function getAll()
    {
        $loggedInUserId = auth()->id();

        return $this->post::with([
            'user',
            'comment',
            'postLike' => function ($query) use ($loggedInUserId) {
                $query->where('user_id', $loggedInUserId);
            },
            'comment.user'
        ])->orderByDesc('created_at')->get();
    }

    public function find($id)
    {
        return $this->post->find($id);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->id();
        $data['media'] = $this->getStorePathFromFile($data['media'], self::STORE_POST_IMAGE_PATH);

        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        $data['media'] = $this->getStorePathFromFile($data['media'], self::STORE_POST_IMAGE_PATH);
        return $this->post->where('id', $id)->update($data);
    }

    public function delete($post)
    {
        return $post->delete();
    }

    public function getAllCount()
    {
        return $this->getAll()->count();
    }

    public function getCurrentDayPosts()
    {
        $today = Carbon::today();
        return $this->post::whereDate('created_at', $today)->get()->count();
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
