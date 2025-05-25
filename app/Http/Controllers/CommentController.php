<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'todo_id' => 'required|exists:todos,id',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // รองรับเฉพาะรูป
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->todo_id = $request->todo_id;
        $comment->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('comments', 'public');
            $comment->image_path = $path;
        }

        $comment->save();

        return response()->json(['comment' => $comment->load('user')]);
    }
}
