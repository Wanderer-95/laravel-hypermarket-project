<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ParamProductService
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

    public static function replicateBatch(Product $product, Product $cloneProduct): void
    {
        foreach ($product->paramProducts as $paramProduct)
        {
            $cloneParamProduct = $paramProduct->replicate();
            $cloneParamProduct->product_id = $cloneProduct->id;
            $cloneParamProduct->push();
        }
    }
}
