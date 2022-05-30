<?php
namespace App\Services;

use App\Repositories\ModuleRepository;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\RoleRepository;
use Carbon\Carbon;

class RoleService extends BaseService{

    protected $role;
    protected $module;

    public function __construct(RoleRepository $role, ModuleRepository $module)
    {
        $this->role   = $role;
        $this->module = $module;

    }

    public function getDatatableData(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->role_name)) {
                $this->role->setRoleName($request->role_name);
            }

            $this->role->setOrderValue($request->input('order.0.column'));
            $this->role->setDirValue($request->input('order.0.dir'));
            $this->role->setLengthValue($request->input('length'));
            $this->role->setStartValue($request->input('start'));

            $list = $this->role->getDatatableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                $action .= ' <a class="dropdown-item edit_data" href="'.route('role.edit',['id'=>$value->id]).'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                $action .= ' <a class="dropdown-item view_data" href="'.route('role.view',['id'=>$value->id]).'"><i class="fas fa-eye text-warning"></i> View</a>';
                if($value->deletable == 1){
                $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->role_name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
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
                if($value->deletable == 1){
                $row[] = '<div class="custom-control custom-checkbox">
                <input type="checkbox" value="'.$value->id.'"
                class="custom-control-input select_data" onchange="select_single_item('.$value->id.')" id="checkbox'.$value->id.'">
                <label class="custom-control-label" for="checkbox'.$value->id.'"></label>
              </div>';
                }else{
                    $row [] = '';
                }
                $row [] = $no;
                $row [] = $value->role_name;
                $row [] = DELETABLE[$value->deletable];
                $row [] = $btngroup;
                $data[] = $row;
            }
            
            return $this->databtableDraw($request->input('draw'), $this->role->count_all(), $this->role->count_filtered(), $data);
        }
    }

    public function storeOrUpdateData(Request $request)
    {
        $collection = collect($request->validated());
        $role = $this->role->updateOrCreate(['id'=>$request->update_id],$collection->all());
        if($role){
            $role->module_role()->sync($request->module);
            $role->permission_role()->sync($request->permission);
            return true;
        }
        return false;
    }

    public function edit(int $id)
    {
        $role = $this->role->findDataWithModulePermission($id);
        $role_module = [];

        if(!$role->module_role->isEmpty())
        {
            foreach ($role->module_role as $value) {
                array_push($role_module,$value->id);
            }
        }

        $role_permission = [];

        if(!$role->permission_role->isEmpty())
        {
            foreach ($role->permission_role as $value) {
                array_push($role_permission,$value->id);
            }
        }

        $data = [
            'role'            => $role,
            'role_module'     => $role_module,
            'role_permission' => $role_permission,
        ];

        return $data;
    }

    public function delete(Request $request)
    {
        $role = $this->role->findDataWithModulePermission($request->id);

        if(!$role->users->isEmpty()){
            $response = 2;
        }else{
            $delete_module_role = $role->module_role()->detach();
            $delete_permission_role = $role->permission_role()->detach();
            if($delete_module_role && $delete_permission_role){
                $role->delete();
                $response = 1;
            }else{
                $response = 3;
            }
        }

        return $response;
    }

    public function bulkDelete(Request $request){
        return $this->role->destroy($request->ids);
    }

    public function PermissionModuleList()
    {
        return $this->module->PermissionModuleList();
    }

    
}