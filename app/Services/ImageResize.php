<?php


namespace App\Services;

use App\Enums\SizeImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageResize
{
    /**

     * @param string $name
     * @param string $repository
     * @param bool $formRequest
     * @return string
     */

    public function saveS3($name = '', $repository = '', $formRequest = false): string
    {
        if ($name === '' || $repository === '') {
            return '';
        }

        $request = request();
        $path = $repository.'/%s/%s/%s';
        $filename = '';

        foreach (SizeImage::getKeys() as $key) {
            $values = SizeImage::getValue($key);

            if ($formRequest) {
                $extension = Str::lower($request->file($name)->getExtension());
                $filename = $request->file($name)->getClientOriginalName();
                $image = Image::make($request->file($name))->resize($values['w'], $values['h'])->encode($extension);
                $pathS3 = sprintf($path, Str::slug($request->get('name')), $key, $filename);
                Storage::disk('s3')->put($pathS3, (string)$image, 'public');
            } else {
                $extension = Str::lower($name->getExtension());
                $filename = $name->getClientOriginalName();
                $image = Image::make($name)->resize($values['w'], $values['h'])->encode($extension);
                $pathS3 = sprintf($path, Str::slug($request->get('name')), $key, $filename);
                Storage::disk('s3')->put($pathS3, (string)$image, 'public');
            }
        }

        return sprintf($path, Str::slug($request->get('name')), '_format_', $filename);;
    }
}
