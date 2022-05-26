<?php
namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository{

    protected $order = array('id' => 'desc');
    protected $moduleID;
    protected $name;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
    
    public function setModuleID($moduleID)
    {
        $this->moduleID = $moduleID;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    private function get_datatable_query()
    {
        $this->column_order = [null,'id','module_id','name','slug',null];

        $query = $this->model->with('module_id,module_name');

        //Search Data:
        if (!empty($this->moduleID)) {
            $query->where('module_id', $this->moduleID);
        }
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
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