<?php
namespace App\repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes, int $id) : bool
    {
        return $this->model->find($id)->update($attributes);
    }

    public function updateOrCreate(array $search_data, array $attributes)
    {
        return $this->model->updateOrCreate($search_data,$attributes);
    }

    public function updateOrInsert(array $search_data, array $attributes)
    {
        return $this->model->updateOrInsert($search_data,$attributes);
    }

    public function all($columns=array('*'), string $orderBy='id', string $sortBy='desc')
    {
        return $this->model->orderBy($orderBy,$sortBy)->get($columns);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    public function delete(int $id) : bool
    {
        return $this->model->find($id)->delete();
    }

    public function destroy(array $data) : bool
    {
        return $this->model->destroy($data);
    }

}