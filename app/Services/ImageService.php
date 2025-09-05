<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ImageService
{
    public static function storeBatch(Product $product, array $images): void
    {
        /**
         * @var UploadedFile $image
         */
        foreach ($images as $image) {
            $path = $image->store('images');
            $product->images()->create([
                'path' => $path,
            ]);
        }
    }
}
