<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\BaseController;

class RoleController extends BaseController
{
    public function __construct(RoleService $role)
    {
        $this->service = $role;
    }

    public function index()
    {
        $this->setPageData('Role','Role','fas fa-th-list');
        return view('role.index');
    }

    public function getDatatableData(Request $request)
    {
        if($request->ajax()){
            $output = $this->service->getDatatableData($request);
        }else{
            $output = ['status' => 'error', 'message' => 'Unauthorized action blocked!'];
        }

        return response()->json($output);
    }

    public function create()
    {
        $this->setPageData('Create Role','Create Role','fas fa-th-list');
        $data = $this->service->PermissionModuleList();
        return view('role.create', compact('data'));
    }

  
    public function storeOrUpdate(RoleRequest $request)
    {
        if($request->ajax()){
            $result = $this->service->storeOrUpdateData($request);
            if($result){
                return $this->response_json($status='success',$message='Data Has Been Saved Successfully',$data=null,$response_code=200);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Save',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function edit(int $id)
    {
        $this->setPageData('Edit Role','Edit Role','fas fa-th-list');
        $data = $this->service->PermissionModuleList();
        $permission_data = $this->service->edit($id);
        return view('role.edit',compact('data','permission_data'));
    }

    public function show(int $id)
    {
        $this->setPageData('Role Details','Role Details','fas fa-th-list');
        $data = $this->service->PermissionModuleList();
        $permission_data = $this->service->edit($id);
        return view('role.view',compact('data','permission_data'));
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            $result = $this->service->delete($request);
            if($result == 1){
                return $this->response_json($status='success',$message='Data Has Been Deleted Successfully',$data=null,$response_code=200);
            }elseif($result == 2){
                return $this->response_json($status='error',$message='Data Cannot Delete Because it\'s related with many users',$data=null,$response_code=204);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Delete',$data=null,$response_code=204);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function bulkDelete(Request $request)
    {
        if($request->ajax()){
            $Result = $this->service->bulkDelete($request);
            if($Result){
                return $this->response_json('success','Data has been deleted successfully',null,200);
            }else{
                return $this->response_json('error','Data cannot be deleted',null,204);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }
}
