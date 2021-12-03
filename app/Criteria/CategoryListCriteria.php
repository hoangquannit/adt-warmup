<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use App\Packages\Repository\Contracts\RepositoryInterface;
use App\Packages\Repository\Contracts\CriteriaInterface;

class CategoryListCriteria implements CriteriaInterface
{
    /**
     * Field list selected
     *
     * @var array
     */
    protected $select = [
        'categories.cat_id',
        'categories.name',
        'categories.created_at',
        'categories.updated_at'
    ];
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $mainTable = 'categories';


    /**
     * CategorieListCriteria constructor.
     * @param Request $request
     */
    public function __construct(
        Request $request
    )
    {
        $this->request = $request;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $sorting = [
            'sort' => $this->request->get('sort'),
            'order' => $this->request->get('order')
        ];

        $options = $this->request->all();

        $sortingTable = $this->mainTable;
        $model = $model->select($this->select);

        if (isset($options['name'])) {
            $model->where($this->mainTable . '.name', 'like', '%' . $options['name'] . '%');
        }

        $sorting = $repository->setOrder($sortingTable, $sorting);

        $model = $model->orderBy($sorting['sort'], $sorting['order']);

        return $model;
    }
}
