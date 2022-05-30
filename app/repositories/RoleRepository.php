<?php
namespace App\Repositories;


use App\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository{

    protected $order = array('id' => 'desc');
    protected $role_name;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }
    
    public function setRoleName($role_name)
    {
        $this->role_name = $role_name;
    }

    private function get_datatable_query()
    {
        $this->column_order = [null,'id','role_name',null,null,null];

        $query = $this->model;

        //Search Data:
        if (!empty($this->role_name)) {
            $query->where('role_name', 'like', '%' . $this->role_name . '%');
        }
        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else if (isset($this->order)) {
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }

        return $query;
    }

    public function getDatatableList()
    {
        $query = $this->get_datatable_query();
        if ($this->lengthVlaue != -1) {
            $query->offset($this->startVlaue)->limit($this->lengthVlaue);
        }
        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->get_datatable_query();
        return $query->get()->count();
    }

    public function count_all()
    {
        return $this->model->toBase()->get()->count();
    }

}