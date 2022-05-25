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

    public function storeOrUpdateData(Request $request)
    {
        $collection   = collect($request->validated());
        $menu_id      = $request->menu_id;
        $created_at   = $updated_at = Carbon::now();
        if($request->update_id){
            $collection = $collection->merge(compact('updated_at'));
        }else{
            $collection = $collection->merge(compact('menu_id','created_at'));
        }

        return $this->module->updateOrCreate(['id'=>$request->update_id],$collection->all());
    }

    public function edit($menu,$module){
        $data['menu']   = $this->menu->withMenuItems($menu);
        $data['module'] = $this->module->findOrFail($module);
        return $data;
    }

    public function delete($module)
    {
        return $this->module->delete($module);
    }


}