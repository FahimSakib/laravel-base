<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\MenuRepository;
use App\Repositories\ModuleRepository;
use Carbon\Carbon;

class MenuService extends BaseService{

    protected $menu;
    protected $module;

    public function __construct(MenuRepository $menu, ModuleRepository $module)
    {
        $this->menu   = $menu;
        $this->module = $module;
    }

    public function getDatatableData(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->menu_name)) {
                $this->menu->setMenuName($request->menu_name);
            }

            $this->menu->setOrderValue($request->input('order.0.column'));
            $this->menu->setDirValue($request->input('order.0.dir'));
            $this->menu->setLengthValue($request->input('length'));
            $this->menu->setStartValue($request->input('start'));

            $list = $this->menu->getDatatableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('menu-builder')){
                $action .= ' <a class="dropdown-item" href="'.route('menu.builder',["id" => $value->id]).'"><i class="fas fa-file-circle-plus  text-success"></i> Builder</a>';
                }
                if(permission('menu-edit')){
                $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('menu-delete')){
                    if($value->deletable == 2){
                    $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->menu_name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                }
                $btngroup = '<div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bars-staggered text-white"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                ' . $action . '
                </div>
              </div>';

                $row = [];
                if(permission('menu-bulk-delete')){
                    if($value->deletable == 2){
                    $row[] = '<div class="custom-control custom-checkbox">
                    <input type="checkbox" value="'.$value->id.'"
                    class="custom-control-input select_data" onchange="select_single_item('.$value->id.')" id="checkbox'.$value->id.'">
                    <label class="custom-control-label" for="checkbox'.$value->id.'"></label>
                </div>';
                    }else{
                        $row [] = '';
                    }
                }
                $row [] = $no;
                $row [] = $value->menu_name;
                $row [] = DELETABLE[$value->deletable];
                $row [] = $btngroup;
                $data[] = $row;
            }
            
            return $this->databtableDraw($request->input('draw'), $this->menu->count_all(), $this->menu->count_filtered(), $data);
        }
    }

    public function storeOrUpdateData(Request $request){
        $collection = collect($request->validated());

        $created_at = $updated_at  = Carbon::now();

        if($request->update_id){
            $collection = $collection->merge(compact('updated_at'));
        }else{
            $collection = $collection->merge(compact('created_at'));
        }

        return $this->menu->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    public function edit(Request $request){
        return $this->menu->find($request->id);
    }

    public function delete(Request $request){
        return $this->menu->delete($request->id);
    }

    public function bulkDelete(Request $request){
        return $this->menu->destroy($request->ids);
    }

    public function orderMenu(array $menuItems, $parent_id)
    {
        foreach ($menuItems as $index => $menuItem) {
            $item               = $this->module->findOrFail($menuItem->id);
            $item->order        = $index + 1;
            $item->parent_id    = $parent_id;
            $item->save();
            if(isset($menuItem->children)){
                $this->orderMenu($menuItem->children, $item->id);
            }
        }

    }
    
}