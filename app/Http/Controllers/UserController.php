<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //display published posts
    public function show_user_posts($id)
    {
        $posts = Posts::where("author_id", $id)->where("active", 1)->orderBy("created_at", "desc")->paginate(20);
        $title = User::findOrFail($id)->name;
        return view("home")->withPosts($posts)->withTitle($title);
    }

    //display all posts (saved & published)
    public function show_all_posts_from_user(Request $request)
    {
        $user = $request->user();
        $posts = Posts::where("author_id", $user->id)->orderBy("created_at", "desc")->paginate(20);
        $title = $user->name;
        return view("home")->withPosts($posts)->withTitle($title);
    }

    //display all saved not published
    public function show_all_posts_from_user_saved(Request $request)
    {
        $user = $request->user();
        $posts = Posts::where("author_id", $user->id)->where("active", 0)->orderBy("created_at", "desc")->paginate(20);
        $title = $user->name;
        return view("home")->withPosts($posts)->withTitle($title);
    }

    // user profile
    public function profile(Request $request, $id)
    {
        $data['user'] = User::findOrFail($id);

        if ($request->user() && $data['user']->id == $request->user()->id)
            $data['author'] = true;
        else
            $data['author'] = false;

        $data['comments_count'] = $data['user']->comments->count();
        $data['posts_count'] = $data['user']->posts->count();
        $data['posts_published_count'] = $data['user']->posts->where('active', '1')->count();
        $data['posts_unpublished_count'] = $data['posts_count'] - $data['posts_published_count'];
        $data['latest_published_posts'] = $data['user']->posts->where('active', '1')->take(20);
        $data['latest_comments'] = $data['user']->comments->take(20);
        return view('admin.profile', $data);
    }
}
