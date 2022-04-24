<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\MenuService;

class MenuController extends BaseController
{
    public function __construct(MenuService $menu)
    {
        $this->service = $menu;
    }
    public function index()
    {
        $this->setPageData('Menu','Menu','fas fa-th-list');
        return view('menu.index');
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
}
