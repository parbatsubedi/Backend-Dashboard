<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendAbout;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class AboutController extends Controller
{

    use UploadImage;
    private $disk = "public";

    public function __construct()
    {
        parent::__construct();
        $this->middleware('permission:Frontend about view')->only('index');
        $this->middleware('permission:Frontend about create')->only('create');
        $this->middleware('permission:Frontend about update')->only('update');
        $this->middleware('permission:Frontend about delete')->only('delete');
    }

    public function index()
    {
        $abouts = FrontendAbout::where('belongs_to',strtolower(config('app.'.'name')))->latest()->get();
        return view('admin.frontend.about.index')->with(compact('abouts'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//                $data['base64_image'] = $this->uploadImageBase64($data['image']);
//            }

            $about = FrontendAbout::create($responseData);

            return redirect()->route('frontend.about.index')->with('success', $about->title . ' successfully created');
        }
        return view('admin.frontend.about.create');
    }

    public function update(Request $request, $id)
    {
        $about = FrontendAbout::whereId($id)->firstOrFail();
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }

            FrontendAbout::whereId($id)->update($responseData);

            return redirect()->back()->with('success', 'Update Successful');
        }
        return view('admin.frontend.about.update')->with(compact('about'));

    }

    public function delete(Request $request)
    {
        $setting = FrontendAbout::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('frontend.about.index')->with('success', 'Data successfully Deleted');
    }
}
