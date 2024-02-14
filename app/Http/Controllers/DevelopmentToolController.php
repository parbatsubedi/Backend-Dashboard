<?php

namespace App\Http\Controllers;


class DevelopmentToolController extends Controller
{

    public function index()
    {
        return view('admin.developmentTool.index');
    }

    public function backup()
    {
        \Illuminate\Support\Facades\Artisan::call('backup:run --only-db');

        return redirect()->route('developmentTool.index');
    }
}
