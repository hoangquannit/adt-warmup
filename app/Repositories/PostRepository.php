<?php
namespace App\Repositories;


use App\Interfaces\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @var string
     */
    protected $mainTable = 'posts';

    /**
     * @return string
     */
    public function model()
    {
        return "App\\Models\\Post";
    }

}