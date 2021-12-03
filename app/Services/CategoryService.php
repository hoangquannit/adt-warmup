<?php

namespace App\Services;

use App\Criteria\CategoryListCriteria;
use App\Http\Requests\CreateRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use mysql_xdevapi\Exception;
use DB;
use Storage;


class CategoryService
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;


    /**
     * CategoryService constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository

    )
    {
        $this->categoryRepository = $categoryRepository;

    }

    /**
     * @param $data
     * @return CategoryRepository[]|\Illuminate\Database\Eloquent\Collection
     */
    public function createCategory( $data)
    {

        DB::beginTransaction();
        try {
            $data ['name'];
            $category = $this->categoryRepository->create($data);
            DB::commit();
            return $category;
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }

    }

    /**
     * @return mixed
     * @throws \App\Packages\Repository\Exceptions\RepositoryException
     */
    public function listCategory()
    {

        $this->categoryRepository->pushCriteria(app(CategoryListCriteria::class));

        $listCategory = $this->categoryRepository->paginate(10);
        return $listCategory;
    }

    /**
     * @param $cat_id
     * @return \App\Models\BaseModel|CategoryRepository|CategoryRepository[]|\Illuminate\Database\Eloquent\Collection|null
     */
    public function detail($cat_id)
    {
        $category = $this->categoryRepository->find($cat_id);
        return $category;
    }

    /**
     * @param $data
     * @param $cat_id
     * @return int
     */
    public function updatePost($data, $cat_id)
    {

        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->find($cat_id);
            if (!$category) return false;
            $dataUpdate = [
                'title' => $data['name'],
            ];
            $category = $this->categoryRepository->update($dataUpdate, $cat_id);
            DB::commit();
            return $category;
        } catch (\Exception $ex) {
            DB::rollback();
            dd($ex->getMessage());
            return $ex->getMessage();
        }

    }

    /**
     * @param $cat_id
     * @return mixed
     */
    public function delete($cat_id)
    {
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->find($cat_id);
            if (!$category) return false;
            $deleteCategory = $this->categoryRepository->delete($cat_id);
            DB::commit();
            return $deleteCategory;
        } catch (\Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }
}
