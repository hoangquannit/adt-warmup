<?php

namespace App\Http\Controllers\API;

use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostAPIController extends Controller
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

    public function listPost()
    {
        $listPost = $this->postService->listPost();

        if (!$listPost) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $listPost], 200);
    }

    public function createPost(Request $request)
    {
        $data = $request->all();
        $post = $this->postService->createPost($data);
        if (!$post) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $post], 200);
    }

    public function updatePost(Request $request, $id)
    {
        $data = $request->all();

        $post= $this->postService->updatePost($data,['id'=> $id] );
        if (!$post) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $post], 200);
    }

    public function deletePost(Request $request, $id)
    {
        $data = $request->all();
        $deletePost = $this->postService->delete($id);
        if (!$deletePost) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $deletePost], 200);
    }
}