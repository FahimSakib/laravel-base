<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\ModuleRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\PermissionRepository;

class PermissionService extends BaseService{

    protected $permission;
    protected $module;

    public function __construct(PermissionRepository $permission, ModuleRepository $module)
    {
        $this->permission = $permission;
        $this->module     = $module;
    }

    public function index()
    {
        $data['modules'] = $this->module->module_list(1); //1=backend menu
        return $data;
    }

    public function getDatatableData(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->module_id)) {
                $this->permission->setModuleID($request->module_id);
            }
            if (!empty($request->name)) {
                $this->permission->setName($request->name);
            }

            $this->permission->setOrderValue($request->input('order.0.column'));
            $this->permission->setDirValue($request->input('order.0.dir'));
            $this->permission->setLengthValue($request->input('length'));
            $this->permission->setStartValue($request->input('start'));

            $list = $this->permission->getDatatableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if (permission('permission-edit')) {
                    $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if (permission('permission-delete')) {
                    $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->menu_name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
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
                if (permission('permission-bulk-delete')) {
                    $row[] = '<div class="custom-control custom-checkbox">
                    <input type="checkbox" value="'.$value->id.'"
                    class="custom-control-input select_data" onchange="select_single_item('.$value->id.')" id="checkbox'.$value->id.'">
                    <label class="custom-control-label" for="checkbox'.$value->id.'"></label>
                    </div>';
                }
                $row [] = $no;
                $row [] = $value->module->module_name;
                $row [] = $value->name;
                $row [] = $value->slug;
                $row [] = $btngroup;
                $data[] = $row;
            }
            
            return $this->databtableDraw($request->input('draw'), $this->permission->count_all(), $this->permission->count_filtered(), $data);
        }
    }

    public function store(Request $request)
    {
        $permission_data = [];
        foreach ($request->permission as $value) {
            $permission_data[] = [
                'module_id' => $request->module_id,
                'name' => $value['name'],
                'slug' => $value['slug'],
                'created_at' => Carbon::now()
            ];
        }
        $result = $this->permission->insert($permission_data);

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionPermissionList();
            }
        }
        return $result;
    }

    public function edit(Request $request)
    {
        $result = $this->permission->find($request->id);

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionPermissionList();
            }
        }
        return $result;
    }

    public function update(Request $request)
    {
        $collection = collect($request->validated());
        $updated_at = Carbon::now();
        $collection = $collection->merge(compact('updated_at'));
        $result = $this->permission->update($collection->all(),$request->update_id);

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionPermissionList();
            }
        }
        return $result;
    }

    public function delete(Request $request)
    {
        $result = $this->permission->delete($request->id);

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionPermissionList();
            }
        }
        return $result;
    }

    public function bulkDelete(Request $request)
    {
        $result = $this->permission->destroy($request->ids);

        if($result){
            if(auth()->user()->role_id == 1){
                $this->restoreSessionPermissionList();
            }
        }
        return $result;
    }

    public function restoreSessionPermissionList()
    {
        $permissions = $this->permission->sessionPermissionList();
        $permission  = [];
        
        if(!$permissions->isEmpty())
        {
            foreach ($permissions as $value) {
                array_push($permission,$value->slug);
            }
            Session::forget('permission');
            Session::put('permission',$permission);
            return true;
        }
        return false;
    }
    
}