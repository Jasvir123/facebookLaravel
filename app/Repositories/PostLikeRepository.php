<?php

namespace App\Repositories;

use App\Models\PostLike;

class PostLikeRepository implements PostLikeRepositoryInterface
{

    protected $postLike;

    public function __construct(PostLike $postLike)
    {
        $this->postLike = $postLike;
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
        return $this->postLike->create($data);
    }
}
