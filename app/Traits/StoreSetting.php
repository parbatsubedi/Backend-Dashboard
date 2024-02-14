<?php


namespace App\Traits;


trait StoreSetting
{
    public function storeSetting($request)
    {

        foreach ($request->all() as $key => $value) {

            if ($request->hasFile($key)) {
                $filename = $this->uploadImage($request->file(`$key`), $key, '/app/public/img/settings/');
                $value = $filename;
            }

            if ($key !== '_token' && $value !== null ) {

                if ($setting =$this->where('option', $key)->first()) {
                    $setting->update(['value' => $value]);
                } else {
                    $setting = new $this;
                    $setting->option = $key;
                    $setting->value = $value;
                    $setting->save();
                }
            }

        }


        return $this->all();
    }
}
