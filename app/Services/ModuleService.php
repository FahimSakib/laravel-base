<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\MenuRepository;
use App\Repositories\ModuleRepository;

class ModuleService extends BaseService{

    protected $module;
    protected $menu;

    public function __construct(ModuleRepository $module, MenuRepository $menu)
    {
        $this->menu = $menu;
        $this->module = $module;
    }

    public function index(int $id)
    {
        $data['menu'] = $this->menu->withMenuItems($id);
        return $data;
    }

}