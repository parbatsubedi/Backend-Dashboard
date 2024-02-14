<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GeneralSettingController extends Controller
{
    use UploadImage;

    public function index()
    {
        $settings = GeneralSetting::latest()->get();
        return view('admin.generalSetting.index')->with(compact('settings'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = Arr::except($request->all(), '_token');

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/settings/');
            }

            GeneralSetting::create($data);
            return redirect()->route('general.setting.index')->with('success', 'New general page created successfully');
        }
        return view('admin.generalSetting.create');
    }

    public function update(Request $request, $id)
    {
        $setting = GeneralSetting::where('id', $id)->firstOrFail();
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/settings/');
            }

            $setting->update($data);

            return redirect()->route('general.setting.index')->with('success', 'Update successful');
        }
        return view('admin.generalSetting.update')->with(compact('setting'));
    }

    public function detail($id)
    {
        $setting = GeneralSetting::where('id', $id)->firstOrFail();
        return view('admin.generalSetting.detail')->with(compact('setting'));
    }

    public function delete(Request $request)
    {
        $setting = GeneralSetting::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('general.setting.index')->with('success', 'Data successfully Deleted');
    }
}
