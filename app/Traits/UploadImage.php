<?php

namespace App\Traits;

use App\Models\User;
use App\Wallet\WalletAPI\Microservice\UploadImageToCoreMicroservice;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Relation for the user
 */
trait UploadImage
{
    public function uploadImage($image, $imageFieldName, $path )
    {
        $extension = $image[$imageFieldName]->getClientOriginalExtension();

        $filename = $imageFieldName . '_' . Carbon::now()->timestamp . '.' . $extension;

        $image[$imageFieldName]->move(storage_path($path), $filename );

        return $filename;
    }

    public function uploadImageBase64($image, $imagePath = null)
    {
        if (empty($imagePath)) $imagePath = asset('/storage/uploads/frontend/');
        $img = file_get_contents($imagePath . '/' . $image);

        return base64_encode($img);
    }

    public function uploadedImageDimensions($image, $imagePath = null)
    {
        if (empty($imagePath)) $imagePath = asset('/storage/uploads/frontend/');
        $img = $imagePath . '/' . $image;
        $imageData = getimagesize($img);
        return [
            'width' => $imageData[0],
            'height' => $imageData[1]
        ];
    }

    public function uploadImageToCoreBase64($disk, $requestData,Request $request)
    {
        foreach($requestData as $key => $value){
            if ($request->hasFile($key)) {
                $encoded_image = base64_encode(file_get_contents($request->file($key)->path()));
                $uploadImage = new UploadImageToCoreMicroservice($encoded_image, $disk);
                $uploadResponse = $uploadImage->uploadImageToCore();
                $decodedUploadResponse = json_decode($uploadResponse);
                $image_file_name = $decodedUploadResponse->filename;
                $requestData[$key] = $image_file_name;
            }
        }
        return $requestData;
    }
}
