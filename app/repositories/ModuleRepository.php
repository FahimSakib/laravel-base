<?php
namespace App\Repositories;

use App\Models\Module;
use App\Repositories\BaseRepository;

class ModuleRepository extends BaseRepository{

    public function __construct(Module $model)
    {
        $this->model = $model;
    }

    public function module_list(int $menu_id)
    {
        $modules = $this->model->orderBy('order','asc')->where(['type'=>2,'menu_id'=>$menu_id])
        ->get()->nest()->setIndent('-- ')->listsFlattened('module_name');

        return $modules;
    }
    
}