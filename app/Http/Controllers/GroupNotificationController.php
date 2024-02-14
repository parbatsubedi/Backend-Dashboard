<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupNotificationController extends Controller
{
    public function createGroup(Request $request)
    {
        if ($request->isMethod('post')) {
            dd($request->all());
        }
    }
}
