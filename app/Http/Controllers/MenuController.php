<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MenuRequest;
use App\Services\MenuService;
use App\Services\ModuleService;

class MenuController extends BaseController
{
    protected $module;

    public function __construct(MenuService $menu, ModuleService $module)
    {
        $this->service = $menu;
        $this->module  = $module;
    }

    public function index()
    {
        if(permission('menu-access')){
            $this->setPageData('Menu','Menu','fas fa-th-list');
            return view('menu.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function getDatatableData(Request $request)
    {
        if(permission('menu-access')){
            if($request->ajax()){
                $output = $this->service->getDatatableData($request);
            }else{
                $output = ['status' => 'error', 'message' => 'Unauthorized action blocked!'];
            }
            
            return response()->json($output);
        }
    }

    public function storeOrUpdateData(MenuRequest $request)
    {
        if($request->ajax()){
            if(permission('menu-add') || permission('menu-edit')){
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

    public function edit(Request $request)
    {
        if($request->ajax()){
            if(permission('menu-edit')){
                $data = $this->service->edit($request);
                if($data->count()){
                    return $this->response_json('success',null,$data,201);
                }else{
                    return $this->response_json('error','No data found',null,204);
                }
            }else{
                return $this->response_json($status='error',$message='Unauthorized Access Blocked',$data=null,$response_code=401);
            }
        }else{
            return $this->response_json('error',null,null,401);
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('menu-delete')){
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
            if(permission('menu-bulk-delete')){
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

    public function orderItem(Request $request){
        $menuItemOrder = json_decode($request->input('order'));
        $this->service->orderMenu($menuItemOrder, null);
        $this->module->restoreSessionModule();
    }
}
