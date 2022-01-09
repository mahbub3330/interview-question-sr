<?php

namespace App\Http\Services;

use App\Models\ProductVariant;

class ProductVariantService
{
    public static function productVariantOptions()
    {
        return ProductVariant::query()
            ->whereIn('variant_id', [1, 2]) // 1 and 2 for size and color that showed inside image
            ->with('variantType')
            ->get()
            ->groupBy('variantType.title')->map(function ($item) {
                return collect($item)->unique('variant')->values()->map(function ($variant) {
                    return [
                        'id' => $variant['variant'],
                        'value' => $variant['variant']
                    ];
                });
            });
    }

}
