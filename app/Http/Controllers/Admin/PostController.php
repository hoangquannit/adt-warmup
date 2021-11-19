<?php

namespace App\Http\Controllers\Admin;

use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PostController extends Controller
{
   /*
    *
    */
    protected $postService;

    /**
     * SocialAuthController constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        return view('posst');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $post = $this->postService->createPost($data);
        if($post) {
            return redirect(route('post_list'));
        }

        return abort(404);
    }

    public function listPost()
    {
        $listPost = $this->postService->listPost();
        return view('post_list', compact('listPost'));
    }
    public function edit( $id)
    {
        $post = $this->postService->detail($id);
        return view('edit_post', compact('post'));
    }
    public function update(Request $request,$id)
    {
        $data = $request->all();

        $post = $this->postService->updatePost($data, $id);
        if ($post) {
            return redirect(route('post_list'));
        }
        return  abort(404);
    }
    public function delete($id)
    {
        $deletePost = $this->postService->delete($id);
        if ($deletePost) {
            return redirect(route('post_list'));
        }
        return  abort(404);
    }
}