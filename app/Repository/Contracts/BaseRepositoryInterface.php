<?php

namespace App\Repository\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface BaseRepositoryInterface
{
   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes): Model;

   /**
    * @param $id
    * @return Model
    */
   public function find($id): ?Model;

   /**
    * @param array $attributes
    * @return Model
    */
   public function update(Model $model, array $attributes) : Model;

   /**
    * @param $id
    * @return Boolean
    */
   public function delete(Model $model) : bool;
}
