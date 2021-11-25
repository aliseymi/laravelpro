<?php

namespace Modules\Main\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();

        return view('main::admin.modules.all',compact('modules'));
    }

    public function disable($module)
    {
        $module = Module::find($module);

        if(Module::canDisable($module->getName()))
            $module->disable();

        return back();
    }

    public function enable($module)
    {
        $module = Module::find($module);

        if(Module::canDisable($module->getName()))
            $module->enable();

        return back();
    }
}
