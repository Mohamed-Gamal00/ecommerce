<?php

namespace App\Helper;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;

trait Helper
{
    public function uploadedImage($request, $fileName, $dirName)
    {
        // if request hasn't it will make this method return null and if not it will return the path
        if (!$request->hasFile($fileName)) {
            return;
        }

        $file = $request->file($fileName); // return uploadedFile object
        $path = $file->store('uploads/' . $dirName, [
            'disk' => 'public'
        ]); // or i can put key and value ('disk' => 'public')
        return $path;
    }

    public function uploadedLogo($request, $fileName, $dirName)
    {
        // if request hasn't it will make this method return null and if not it will return the path
        if (!$request->hasFile($fileName)) {
            return;
        }

        $file = $request->file($fileName); // return uploadedFile object
        $path = $file->store('uploads/' . $dirName, [
            'disk' => 'public'
        ]); // or i can put key and value ('disk' => 'public')
        return $path;
    }


    /* favourit products */
    public function checkIfProductExists(Request $request, $productId = null)
    {
//        $userId = $request->header('userId');

        $userId = $request->user()->id ?? $request->header('user-id');
        $guestId = $request->header('guest-id');

        if ($userId) {
            $user = User::findOrFail($userId);
            $product = $user->wishlistProducts->where('id', $productId)->first();
            if ($product) {
                return true;
            }
            return false;
        }


        if ($guestId) {
            $guest = Guest::find($guestId);
            $product = $guest->wishlistProducts->where('id', $productId)->first();
            if ($product) {
                return true;
            }
            return false;

        }
        return false;
    }
}
