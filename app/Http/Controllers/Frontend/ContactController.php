<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\FrontendContact;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class ContactController extends Controller
{
    use UploadImage;
    private $disk = "public";

    public function index(Request $request)
    {
        $contact = FrontendContact::where('belongs_to',strtolower(config('app.'.'name')))->latest()->first();

        if ($request->isMethod('post')) {

            $data = Arr::except($request->all(), '_token');
            $responseData = $this->uploadImageToCoreBase64($this->disk, $data, $request);
//            if ($request->hasFile('logo')) {
//                $data['logo'] = $this->uploadImage(['logo' => $request->file('logo')], 'logo', 'app/public/uploads/frontend/');
//            }

            if (empty($contact)) {
                FrontendContact::create($responseData);
            }
            FrontendContact::where('id', 1)->update($responseData);

            return redirect()->route('frontend.contact')->with(compact('contact'));
        }

        return view('admin.frontend.contact.index')->with(compact('contact'));
    }
}
