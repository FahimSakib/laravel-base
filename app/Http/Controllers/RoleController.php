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
        if (permission('role-access')) {
            $this->setPageData('Role','Role','fas fa-th-list');
            return view('role.index');
        } else {
            return $this->unauthorized_access_blocked();
        }
    }

    public function getDatatableData(Request $request)
    {
        if (permission('role-access')) {
            if($request->ajax()){
                $output = $this->service->getDatatableData($request);
            }else{
                $output = ['status' => 'error', 'message' => 'Unauthorized action blocked!'];
            }

            return response()->json($output);
        }
    }

    public function create()
    {
        if (permission('role-add')) {
            $this->setPageData('Create Role','Create Role','fas fa-th-list');
            $data = $this->service->PermissionModuleList();
            return view('role.create', compact('data'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

  
    public function storeOrUpdate(RoleRequest $request)
    {
        if($request->ajax()){
            if (permission('role-add') || permission('role-edit')) {
                $result = $this->service->storeOrUpdateData($request);
                if($result){
                    return $this->response_json($status='success',$message='Data Has Been Saved Successfully',$data=null,$response_code=200);
                }else{
                    return $this->response_json($status='error',$message='Data Cannot Save',$data=null,$response_code=204);
                }
            }else{
                    return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
                }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function edit(int $id)
    {
        if (permission('role-edit')) {
            $this->setPageData('Edit Role','Edit Role','fas fa-th-list');
            $data = $this->service->PermissionModuleList();
            $permission_data = $this->service->edit($id);
            return view('role.edit',compact('data','permission_data'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function show(int $id)
    {
        if (permission('role-view')) {
            $this->setPageData('Role Details','Role Details','fas fa-th-list');
            $data = $this->service->PermissionModuleList();
            $permission_data = $this->service->edit($id);
            return view('role.view',compact('data','permission_data'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if (permission('role-delete')) {
            $result = $this->service->delete($request);
            if($result == 1){
                return $this->response_json($status='success',$message='Data Has Been Deleted Successfully',$data=null,$response_code=200);
            }elseif($result == 2){
                return $this->response_json($status='error',$message='Data Cannot Delete Because it\'s related with many users',$data=null,$response_code=204);
            }else{
                return $this->response_json($status='error',$message='Data Cannot Delete',$data=null,$response_code=204);
            }
        }else{
            return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
        }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function bulkDelete(Request $request)
    {
        if($request->ajax()){
            if (permission('role-bulk-delete')) {
                $result = $this->service->bulkDelete($request);
                if($result['status'] == 1){
                    return $this->response_json($status='success',$message= !empty($result['message']) ? $result['message'] : 'Data Has Been Deleted Successfully',$data=null,$response_code=200);
                }elseif($result['status'] == 2){
                    return $this->response_json($status='error',$message= !empty($result['message']) ? $result['message'] : 'Selected Data Cannot Delete',$data=null,$response_code=204);
                }else{
                    return $this->response_json($status='error',$message= !empty($result['message']) ? $result['message'] : 'Selected Data Cannot Delete',$data=null,$response_code=204);
                }
            }else{
                return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }
}
