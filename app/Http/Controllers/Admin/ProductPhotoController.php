<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    public function removePhoto(Request $request)
    {
        $image = $request->get('image');

        if (Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }

        $productPhoto = ProductPhoto::where('image', $image);
        $productId = $productPhoto->first()->product_id;
        $productPhoto->delete();
        flash('Imagem removida.')->success();
        return redirect()->route('admin.products.edit', ['product' => $productId]);
    }
}
