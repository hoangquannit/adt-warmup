<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use App\Packages\Repository\Contracts\RepositoryInterface;
use App\Packages\Repository\Contracts\CriteriaInterface;

class PostListCriteria implements CriteriaInterface
{
    /**
     * Field list selected
     *
     * @var array
     */
    protected $select = [
        'posts.id',
        'posts.cat_id',
        'posts.title',
        'posts.content',
        'posts.img',
        'posts.created_at',
        'posts.updated_at'
    ];
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $mainTable = 'posts';


    /**
     * PostListCriteria constructor.
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

        if (isset($options['cat_id'])) {
            $model->where($this->mainTable . '.cat_id', 'like', '%' . $options['cat_id'] . '%');
        }

        if (isset($options['title'])) {
            $model->where($this->mainTable . '.title', 'like', '%' . $options['title'] . '%');
        }

        if (isset($options['content'])) {
            $model->where($this->mainTable . '.content', 'like', '%' . $options['content'] . '%');
        }

        if (isset($options['img'])) {
            $model->where($this->mainTable . '.img', 'like', '%' . $options['img'] . '%');
        }

        $sorting = $repository->setOrder($sortingTable, $sorting);

        $model = $model->orderBy($sorting['sort'], $sorting['order']);

        return $model;
    }
}
