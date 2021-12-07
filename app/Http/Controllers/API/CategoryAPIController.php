<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryAPIController extends Controller
{
    /*
     *
     */
    protected $categoryService;

    /**
     * CategoryAPIController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function listCategory()
    {
        $listCategory = $this->categoryService->listCategory();

        if (!$listCategory) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $listCategory], 200);
    }

    public function createCategory(Request $request)
    {
        $data = $request->all();
        $category = $this->categoryService->createCategory($data);
        if (!$category) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $category], 200);
    }

    public function updateCategory(Request $request, $id)
    {
        $data = $request->all();

        $category= $this->categoryService->updateCategory($data,$id );
        if (!$category) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $category], 200);
    }

    public function deleteCategory(Request $request, $id)
    {
        $data = $request->all();
        $deleteCategory = $this->categoryService->delete($id);
        if (!$deleteCategory) {
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $deleteCategory], 200);
    }

    public function getDetail(Request $request, $id)
    {
        $data = $request->all();
        $category = $this->categoryService->detail($id);
        if(!$category){
            return response()->json(['msg' => __('errors')  ],500);
        }
        return response()->json(['msg' => __('ok'), 'data' => $category], 200);
    }

}