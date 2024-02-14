<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendAbout;
use App\Models\Frontend\FrontendFaq;
use App\Models\Frontend\FrontendSolution;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class SolutionController extends Controller
{

    use UploadImage;
    private $disk = "public";

    public function index()
    {
        $solutions = FrontendSolution::where('belongs_to',strtolower(config('app.'.'name')))->latest()->get();
        return view('admin.frontend.solution.index')->with(compact('solutions'));
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

            FrontendSolution::create($responseData);
            return redirect()->route('frontend.solution.index')->with('success',' successfully created solution');
        }
        return view('admin.frontend.solution.create');
    }

    public function update(Request $request, $id)
    {
        $solution = FrontendSolution::whereId($id)->firstOrFail();
        if ($request->isMethod('post')) {
            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
//            if ($request->hasFile('image')) {
//                $data['image'] = $this->uploadImage(['image' => $request->file('image')], 'image', 'app/public/uploads/frontend/');
//            }

            FrontendSolution::whereId($id)->update($responseData);

            return redirect()->route('frontend.solution.index')->with('success', 'Update Successful');
        }
        return view('admin.frontend.solution.update')->with(compact('solution'));

    }

    public function delete(Request $request)
    {
        $setting = FrontendSolution::where('id', $request->id)->firstOrFail();
        $setting->delete();

        return redirect()->route('frontend.solution.index')->with('success', 'Data successfully Deleted');
    }
}
