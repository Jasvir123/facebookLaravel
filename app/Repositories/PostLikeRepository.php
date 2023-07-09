<?php

namespace App\Repositories;

use App\Models\PostLike;

class PostRepository implements PostRepositoryInterface
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
}
