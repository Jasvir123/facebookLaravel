<?php

namespace App\Repositories;

use App\Models\PostLike;
use Carbon\Carbon;
use App\Repositories\SettingRepositoryInterface;

class PostLikeRepository implements PostLikeRepositoryInterface
{

    protected $postLike, $settingRepository;

    public function __construct(PostLike $postLike, SettingRepositoryInterface $settingRepository)
    {
        $this->postLike = $postLike;
        $this->settingRepository = $settingRepository;
    }

    public function getAll()
    {
        return $this->postLike::get();
    }

    public function find($id)
    {
        return $this->postLike->find($id);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->id();
        return $this->postLike->create($data);
    }

    public function update($id, $data)
    {
        return $this->postLike->where('id', $id)->update($data);
    }

    public function delete($postLike)
    {
        return $postLike->delete();
    }

    public function postLikeUnlike($post_id)
    {
        $data['user_id'] = auth()->id();
        $data['post_id'] = $post_id;

        $postLike = $this->postLike::where(
            ['post_id' => $data['post_id']],
            ['user_id' => $data['user_id']],
        )->get();

        if (count($postLike) > 0) {
            return $this->delete($postLike->first());
        }
        if ($this->canLikeToday()) {
            return $this->postLike->create($data);
        }
        return false;
    }

    public function getCurrentDayLikes()
    {
        $today = Carbon::today();
        return $this->postLike::whereDate('created_at', $today)->get()->count();
    }

    public function canLikeToday()
    {
        $currentDayLikes = $this->getCurrentDayLikes();
        $currentDayMaxLikes = $this->settingRepository->getCurrentDayMaxLikes();

        if ($currentDayLikes >= $currentDayMaxLikes) {
            return false;
        }
        return true;
    }
}
