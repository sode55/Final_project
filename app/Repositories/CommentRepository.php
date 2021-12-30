<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Company;

class CommentRepository
{
    public function save($request)
    {
        $comment = Comment::create([
            'title' => $request->title,
            'content' => $request->content,
            'company_id' => $request->company_id,
        ]);

        return $comment;
    }

    public function list()
    {
        $comments = Company::with(['comments' => function ($query) {
            $query->select('title', 'content', 'created_at', 'company_id');
        }])
            ->select('company_name','id')
            ->get();

        return $comments;
    }
}
