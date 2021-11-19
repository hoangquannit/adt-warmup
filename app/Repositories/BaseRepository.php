<?php

namespace App\Repositories;

use Illuminate\Container\Container;
use App\Models\BaseModel as Model;
use Schema;
abstract class BaseRepository
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * Default page name
     * @var string
     */
    protected $pageName = 'page';

    /**
     * Default order field
     *
     * @var string
     */
    protected $orderDefault = 'updated_at';

    /**
     * Default order direction
     *
     * @var string
     */
    protected $defaultDirection = 'desc';

    /**
     * BaseRepository constructor.
     *
     * @param Container $app
     */
    public function __construct(Container $app)  //Khởi tạo
    {
        $this->app = $app;
    }

    /**
     * Specify Model
     *
     * @return mixed
     */
    abstract function model(); //lấy model tương ứng

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($columns = ['*'])
    {
        return $this->makeModel()->get($columns);
    }

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function first($columns = ['*'])
    {
        return $this->makeModel()->get($columns)->first();
    }

    /**
     * @param int $limit
     * @param array $conditions
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function pagination($limit = 20, $conditions = [])
    {
        if ($columns = array_get($conditions, 'columns')) {
            return $this->makeModel()->paginate($limit, $columns, $this->pageName);
        }

        return $this->makeModel()->paginate($limit, ['*'], $this->pageName);
    }

    /**
     * @param $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function findById($id, $columns = ['*'])
    {
        return $this->makeModel()->find($id, $columns);
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByField($field, $value, $columns = ['*'])
    {
        return $this->makeModel()->where($field, $value)->get($columns);
    }

    /**
     * Fild data by mutil field.
     *
     * @param array $fields
     * @param array $columns
     *
     * @return mixed
     * @throws \Exception
     */
    public function findByMutilField($fields = [], $columns = ['*'])
    {
        $query = $this->makeModel();
        foreach ($fields as $fieldKey => $fieldValue) {
            $query->where($fieldKey, $fieldValue);
        }

        return $query->get($columns);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function create($data = [])
    {
        $model = $this->app->make($this->model());
        $model->fill($data);
        $model->save();
        return $model;
    }

    /**
     * @param array $conditions
     * @param array $data
     *
     * @return int
     */
    public function update($conditions = [], $data = [])
    {
        $model = $this->makeModel();
        foreach ($conditions as $field => $value) {
            $model->where($field, $value);
        }
        return $model->update($data);
    }

    /**
     * Run the logical delete when using softDelete
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        return $this->makeModel()
            ->find($id)
            ->delete();
    }

    /**
     * Run the physical delete when using softDelete
     *
     * @param $id
     *
     * @return mixed
     */
    public function forceDelete($id)
    {
        return $this->makeModel()
            ->find($id)
            ->forceDelete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \Exception
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $model->newQuery();
    }

    /**
     * Get page name
     *
     * @return string
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * @param $table Table name to check field isset
     *
     * @param array $sorting sorting options
     *
     * @return array
     */
    public function setOrder($table, $sorting = [], $checkTable = true)
    {
        $field = array_get($sorting, 'sort');
        $direction = array_get($sorting, 'order');

        if (Schema::hasColumn($table, $field) && ($direction == 'desc' || $direction == 'asc')) {
            return [
                'sort' => $table . '.' . $field,
                'order' => $direction
            ];

        }
        return [
            'sort' => $table . '.' . $this->orderDefault,
            'order' => $this->defaultDirection
        ];
    }

    public function chunkRecord($table, $column, $limit = 1000)
    {
        $collection = collect();
        $table->select($column)->chunk($limit, function ($records) use ($collection) {
            foreach ($records as $element) {
                $collection->push($element);
            }
        });

        return $collection;
    }
}