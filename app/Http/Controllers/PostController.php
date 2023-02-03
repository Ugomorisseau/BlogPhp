<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PhpParser\Node\Scalar\String_;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'post')->where('post_id')->latest()->get();
//        dd($posts);
        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'max:300'],
            'user_id' => ['exists:users,id']
        ]);

        Post::create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id
        ]);

        return Redirect::route('posts.index');

    }

    public function postResponse(Post $post, string $content)
    {

        Post::create([
            'content' => $content,
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);

        return Redirect::route('posts.index');

    }

    public function destroy(Post $post){
        $post->delete();
        return Redirect::route('posts.index');

    }

    public function profile(User $user){

        $profileUser = $user;

        $posts = $user -> posts;
        return Inertia::render('Posts/Profile', [
            'profileUser' => $profileUser,
            'posts' => $posts
        ]);
    }
}
