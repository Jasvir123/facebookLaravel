<?php
namespace App\Services;

use App\Models\Comment;

class CommentService
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getAll()
    {
        return $this->comment::with('user')->get();
    }

    public function find($id)
    {
        return $this->comment->with('user')->find($id);
    }

    public function findCommentsByPostId($post_id)
    {
        return $this->comment->with('user')->where('post_id', $post_id)->get();
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
