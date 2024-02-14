<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendAbout;
use App\Models\Frontend\FrontendFaq;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class FaqController extends Controller
{

    use UploadImage;
    private $disk = "public";

    public function index()
    {
        $faqs = FrontendFaq::where('belongs_to',strtolower(config('app.'.'name')))->latest()->get();
        return view('admin.frontend.faq.index')->with(compact('faqs'));
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

            $about = FrontendFaq::create($responseData);
            return redirect()->route('frontend.faq.index')->with('success',' successfully created faq');
        }
        return view('admin.frontend.faq.create');
    }

    public function update(Request $request, $id)
    {
        $faq = FrontendFaq::whereId($id)->firstOrFail();
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }

            FrontendFaq::whereId($id)->update($responseData);

            return redirect()->route('frontend.faq.index')->with('success', 'Update Successful');
        }
        return view('admin.frontend.faq.update')->with(compact('faq'));

    }

    public function delete(Request $request)
    {
        $setting = FrontendFaq::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('frontend.faq.index')->with('success', 'Data successfully Deleted');
    }
}
