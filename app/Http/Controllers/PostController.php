<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;

class PostController extends Controller
{
    public function index()
    {
        //find latest 20 posts from db
        $posts = Posts::where("active", 1)->orderBy("created_by", "desc")->paginate(20);
        //heading
        $title = "Newest Posts";
        //return blade view
        return view("home")->withPosts($posts)->withTitle($title);
    }

    public function show_new_post(Request $request)
    {
        if ($request->user()->can_post())
            return view('posts.create');
        else
            return redirect('/')->withErrors('You have no privileges to post');
    }

    public function save_post(Request $request)
    {
        $post = new Posts();
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->body = $request->body;
        $post->slug = Str::slug($post->title);

        $checkPostSlug = Posts::where('slug', $post->slug)->first();
        if ($checkPostSlug)
            return redirect('new_post')->withErrors("Title already exists")->withInput();

        $post->author_id = $request->user()->id;
        if ($request->has("save")) {
            $post->active = 0;
            $message = "Post saved";
        } else {
            $post->active = 1;
            $message = "Post published";
        }
        $post->save();
        return redirect('edit/', $post->slug)->withMessage($message);
    }

    public function show($slug)
    {
        $post = Posts::where("slug", $slug)->first();
        if (!$post)
            return redirect("/")->withErrors("Requested page doesnt exist");
        $comments = $post->comments;
        return view("posts.show")->withPost($post)->withComments($comments);
    }

    public function edit(Request $request, $slug)
    {
        $post = Posts::where("slug", $slug)->first();
        //check if user is the author or if user is admin to edit
        if ($request->user()->id == $post->author_id || $request->user()->is_admin())
            return view("posts.edit")->with("post", $post);
        else
            return redirect("/")->withErrors("You have no privileges");
    }

    public function update(Request $request)
    {
        $post_id = $request->post_id;
        $post = Posts::findOrFail($post_id);
        //check if post exists,if the user is current author or admin
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $title = $request->title;
            $slug = Str::slug($title);
            $findDuplicate = Posts::where("slug", $slug)->first();
            if ($findDuplicate) {
                if ($findDuplicate->id == $post_id) {
                    return redirect("edit/" . $post->slug)->withErrors("Title already exists.")->withInput();
                } else {
                    $post->slug = $slug;
                }
            }
            $post->title = $title;
            $post->body = $request->body;

            if ($request->has("save")) {
                $post->active = 0;
                $message = "Post saved";
                $page = "edit/" . $post->slug;
            } else {
                $post->active = 1;
                $message = "Post updated";
                $page = $post->slug;
            }
            $post->save();
            return redirect($page)->withMessage($message);
        } else {
            return redirect("/")->withErrors("You have no permission to save or update");
        }
    }

    public function destroy(Request $request, $id)
    {
        $post = Posts::findOrFail($id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin()))
        {
            $post->delete();
            $data['message']="Post deleted succesfully";
        }
        else {
            $data['message'] = "You have no permission to delete this post";
        }
        return redirect("/")->with($data);
    }

}
