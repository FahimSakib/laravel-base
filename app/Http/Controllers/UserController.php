<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserFormRequest;
use App\Services\RoleService;
use App\Services\UserService;

class UserController extends BaseController
{
    protected $role;

    public function __construct(UserService $user, RoleService $role)
    {
        $this->service = $user;
        $this->role    = $role;
    }
    public function index()
    {
        $this->setPageData('User','User','fas fa-users');
        $roles = $this->role->index();
        return view('user.index',compact('roles'));
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

    public function storeOrUpdateData(UserFormRequest $request)
    {
        if($request->ajax()){
            $Result = $this->service->storeOrUpdateData($request);
            if($Result){
                return $this->response_json('success','Data has been saved successfully',null,200);
            }else{
                return $this->response_json('error','Data cannot be saved',null,204);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            $data = $this->service->edit($request);
            if($data->count()){
                return $this->response_json('success',null,$data,201);
            }else{
                return $this->response_json('error','No data found',null,204);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            $Result = $this->service->delete($request);
            if($Result){
                return $this->response_json('success','Data has been deleted successfully',null,200);
            }else{
                return $this->response_json('error','Data cannot be deleted',null,204);
            }
        }else{
            return $this->response_json('error',null,null,401);
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
