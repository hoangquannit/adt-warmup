<?php
namespace App\Repositories;


use App\Interfaces\CategoryRepositoryInterface;


class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * @var string
     */
    protected $mainTable = 'categories';

    /**
     * @return string
     */
    public function model()
    {
        return "App\\Models\\Category";
    }

}