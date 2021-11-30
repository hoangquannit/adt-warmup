<?php

namespace App\Services;

use App\Criteria\PostListCriteria;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Posts;
use App\Repositories\PostRepository;
use mysql_xdevapi\Exception;
use DB;
use Storage;


class PostService
{
    /**
     * @var PostRepository
     */
    protected $postRepository;


    /**
     * AccountService constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(
        PostRepositoryInterface $postRepository

    )
    {
        $this->postRepository = $postRepository;

    }

    /**
     * @param $data
     * @return PostRepository[]|\Illuminate\Database\Eloquent\Collection
     */
    public function createPost($data)
    {

        DB::beginTransaction();
        try {
            $data ['title'];
            $data['content'];
            $data['img'];
            $img= $data['img'];
            $filename =  $data['img']->getClientOriginalName();
            Storage::disk('public')->put($filename, \File::get( $img));
            $data['img']=$filename;
            $post = $this->postRepository->create($data);
            DB::commit();
            return $post;
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }

    }

    /**
     * @return mixed
     * @throws \App\Packages\Repository\Exceptions\RepositoryException
     */
    public function listPost()
    {

        $this->postRepository->pushCriteria(app(PostListCriteria::class));

        $listPost = $this->postRepository->paginate(10);
        return $listPost;
    }

    /**
     * @param $id
     * @return \App\Models\BaseModel|PostRepository|PostRepository[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public function detail($id)
    {
        $post = $this->postRepository->findById($id);
        return $post;
    }

    /**
     * @param $data
     * @param $id
     * @return int
     */
    public function updatePost($data, $id)
    {

        DB::beginTransaction();
        try {
            $post = $this->postRepository->find($id);
            if (!$post) return false;
            $dataUpdate = [
                'title' => $data['title'],
                'content' => $data['content'],
                'img' => $data['img']
            ];
            $filename =  $data['img']->getClientOriginalName();
            Storage::disk('public')->put($filename, \File::get( $data['img']));
            $dataUpdate['img']=$filename;
            $post = $this->postRepository->update($dataUpdate, $id);
            DB::commit();
            return $post;
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return $ex->getMessage();
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->findById($id);
            if (!$post) return false;
            $deletePost = $this->postRepository->delete($id);
            DB::commit();
            return $deletePost;
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }
}
