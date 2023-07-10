<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getAll()
    {
        return $this->comment::get();
    }

    public function find($id)
    {
        return $this->comment->find($id);
    }

    public function create($data)
    {
        $data['user_id'] = auth()->id();
        return $this->comment->create($data);
    }

    public function update($id, $data)
    {
        return $this->comment->where('id', $id)->update($data);
    }

    public function delete($comment)
    {
        return $comment->delete();
    }
}
