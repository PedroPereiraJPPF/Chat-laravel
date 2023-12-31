<?php

namespace App\Repository;

use App\Repository\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
        protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll($paginate = 15)
    {
        return $this->model->paginate($paginate);
    }

    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
    * @param array $attributes
    * @return Model
    */
    public function update(Model $model, array $attributes) : Model
    {
        $model->update($attributes);
        return $model;
    }

    /**
    * @param $id
    * @return Boolean
    */
    public function delete(Model $model) : bool
    {
        return $model->delete();
    }
}
