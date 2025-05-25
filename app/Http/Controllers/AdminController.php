<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::withCount(['todos', 'comments'])->get();

        return view('admin.dashboard', compact('users'));
    }

    public function showUserTodos($userId)
    {
        $todos = Todo::where('user_id', $userId)
            ->with(['comments' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.user_todos', compact('todos'));
    }

    public function showUserComments($userId)
    {
        $comments = Comment::where('user_id', $userId)
            ->with('todo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.user_comments', compact('comments'));
    }


    public function editTodo($id)
    {
        $todo = Todo::findOrFail($id);
        return view('admin.edit_todo', compact('todo'));
    }

    public function updateTodo(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]));

        return redirect()->route('admin.user.todos', $todo->user_id)->with('success', 'Todo updated successfully');
    }

    public function destroyTodo($id)
    {
        $todo = Todo::findOrFail($id);
        $userId = $todo->user_id;
        $todo->delete();

        return redirect()->route('admin.user.todos', $userId)->with('success', 'Todo deleted successfully');
    }

    public function editComment($id)
    {
        $comment = Comment::findOrFail($id);
        return view('admin.edit_comment', compact('comment'));
    }

    public function updateComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $request->validate([
            'content' => 'required|string',
        ]);
        $comment->update(['content' => $request->content]);

        return redirect()->route('admin.user.comments', $comment->user_id)->with('success', 'Comment updated successfully');
    }

    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $userId = $comment->user_id;
        $comment->delete();

        return redirect()->route('admin.user.comments', $userId)->with('success', 'Comment deleted successfully');
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

   public function updateUser(Request $request, User $user)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed', // password_confirmed จะถูกตรวจสอบอัตโนมัติ
    ]);

    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];

    if (!empty($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']);
    }

    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'User updated successfully');
}

    public function destroyUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }
}
