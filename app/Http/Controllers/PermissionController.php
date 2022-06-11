<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionController extends BaseController
{
    public function __construct(PermissionService $permission)
    {
        $this->service = $permission;
    }
    public function index()
    {
        if (permission('permission-access')){
            $this->setPageData('Permission','Permission','fas fa-th-list');
            $data = $this->service->index();
            return view('permission.index',compact('data'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function getDatatableData(Request $request)
    {
        if (permission('permission-access')){
            if($request->ajax()){
                $output = $this->service->getDatatableData($request);
            }else{
                $output = ['status' => 'error', 'message' => 'Unauthorized action blocked!'];
            }

            return response()->json($output);
        }
    }

  
    public function store(PermissionRequest $request)
    {
        if($request->ajax()){
            if (permission('permission-add')){
                $result = $this->service->store($request);
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

    public function edit(Request $request)
    {
        if($request->ajax()){
            if (permission('permission-edit')){
                $data = $this->service->edit($request);
                if($data->count()){
                    return $this->response_json($status='success',$message=null,$data=$data,$response_code=201);
                }else{
                    return $this->response_json($status='error',$message='No Data Found',$data=null,$response_code=204);
                }
            }else{
                return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function update(PermissionUpdateRequest $request)
    {
        if($request->ajax()){
            if (permission('permission-edit')){
                $result = $this->service->update($request);
                if($result){
                    return $this->response_json($status='success',$message='Data Has Been Updated Successfully',$data=null,$response_code=200);
                }else{
                    return $this->response_json($status='error',$message='Data Cannot Update',$data=null,$response_code=204);
                }
            }else{
                return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
            }
        }else{
           return $this->response_json($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if (permission('permission-delete')){
                $Result = $this->service->delete($request);
                if($Result){
                    return $this->response_json('success','Data has been deleted successfully',null,200);
                }else{
                    return $this->response_json('error','Data cannot be deleted',null,204);
                }
            }else{
                return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }

    public function bulkDelete(Request $request)
    {
        if($request->ajax()){
            if (permission('permission-bulk-delete')){
                $Result = $this->service->bulkDelete($request);
                if($Result){
                    return $this->response_json('success','Data has been deleted successfully',null,200);
                }else{
                    return $this->response_json('error','Data cannot be deleted',null,204);
                }
            }else{
                return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }

}
