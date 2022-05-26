<?php
namespace App\Repositories;

use App\Models\Module;
use App\Repositories\BaseRepository;

class ModuleRepository extends BaseRepository{

    public function __construct(Module $model)
    {
        $this->model = $model;
    }
    
}