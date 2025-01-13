<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Str;

trait ImageCustomization
{
  public static function resizeImageWithoutStore($imagePath, $width, $height)
  {
    // relative path => /storage/uploads/categories_images/EjjSqhO7FQcFIcfo5SYdcAiPwsT5sLa8bO6krvqv.png
    $convertPathToRelativePath = Str::after($imagePath, '/public');
    $relativePath = public_path($convertPathToRelativePath);

    if (!\file_exists($relativePath)) {
      return null;
    }

    $image = Image::make($relativePath);
    $image->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
      //            $constraint->upsize();
    });


    return $image;
  }

  public static function resizeImageWithStore($image, $width, $height, $dirName, $addWaterMark = false, $convertToJpg = false)
  {
    $fileName = time() . '_' . $image->getClientOriginalName();
    $storageDirectory = storage_path('app/public/uploads/' . $dirName);
    $path = $storageDirectory . '/' . $fileName;

    File::ensureDirectoryExists($storageDirectory);
    $convertToJpg = $convertToJpg == true ? 'jpg' : null;


    $image = Image::make($image);
    $image->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
      //            $constraint->upsize();
    });
    if ($addWaterMark == true) {
      $image->insert('public/front/images/marksss.png', 'top-left', 3, 3);
    }
    $image->save($path, null, $convertToJpg);

    $finalPath = 'uploads/' . $dirName . '/' . $fileName;

    return $finalPath;
  }

  public static function reduceImageQualityWithStore($image, $quality, $dirName, $addWaterMark = false, $maxImageSizeInMb = null, $convertToJpg = false)
  {
    $imageSizeInMB = (\round(filesize($image) / 1024 / 1024, 3));
    // check if the image >= $maxImageSizeInMb and if not null here mean keep image quality
    $quality = $imageSizeInMB >= $maxImageSizeInMb ? $quality : null;
    $convertToJpg = $convertToJpg == true ? 'jpg' : null;

    $fileName = time() . '_' . $image->getClientOriginalName();
    $storageDirectory = storage_path('app/public/uploads/' . $dirName);
    $path = $storageDirectory . '/' . $fileName;

    File::ensureDirectoryExists($storageDirectory);

    $image = Image::make($image);
    if ($addWaterMark == true) {
      $image->insert('public/front/images/marksss.png', 'top-left', 3, 3);
    }
    $image->save($path, $quality, $convertToJpg);

    $finalPath = 'uploads/' . $dirName . '/' . $fileName;
    return $finalPath;
  }

  public static function storeFile(Request $request, $fileName, $dirName)
  {
    if (!$request->hasFile($fileName)) {
      return null;
    }
    $file = $request->file($fileName);
    $path = $file->store('uploads/' . $dirName, 'public');
    return $path;
  }
}
