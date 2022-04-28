<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\ModuleService;

class ModuleController extends BaseController
{
    public function __construct(ModuleService $module)
    {
        $this->service = $module;
    }
    public function index(int $id)
    {
        $this->setPageData('Menu Builder','Menu builder','fas fa-th-list');
        $data = $this->service->index($id);
        return view('module.index', compact('data'));
    }

}
