<?php
namespace App\Repositories;


class PostRepository extends BaseRepository
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