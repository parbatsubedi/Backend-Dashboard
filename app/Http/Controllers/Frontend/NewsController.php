<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendAbout;
use App\Models\Frontend\FrontendFaq;
use App\Models\Frontend\FrontendNews;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class NewsController extends Controller
{

    use UploadImage;
    private $disk = "public";

    public function index()
    {
        $news = FrontendNews::where('belongs_to',strtolower(config('app.'.'name')))->latest()->get();
        return view('admin.frontend.news.index')->with(compact('news'));
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

            $about = FrontendNews::create($responseData);
            return redirect()->route('frontend.news.index')->with('success',' successfully created faq');
        }
        return view('admin.frontend.news.create');
    }

    public function update(Request $request, $id)
    {
        $news = FrontendNews::whereId($id)->firstOrFail();
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }

            FrontendNews::whereId($id)->update($responseData);

            return redirect()->route('frontend.news.index')->with('success', 'Update Successful');
        }
        return view('admin.frontend.news.update')->with(compact('news'));

    }

    public function delete(Request $request)
    {
        $setting = FrontendNews::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('frontend.news.index')->with('success', 'Data successfully Deleted');
    }
}
