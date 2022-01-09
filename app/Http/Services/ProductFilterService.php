<?php

namespace App\Http\Services;

use App\Models\Product;

class ProductFilterService
{
    public static function filterProducts($request)
    {
        return Product::query()
            ->where('title', 'like', '%' . $request->get('title') . '%')
            ->when($request->get('data'), function ($q) use ($request) {
                return $q->whereDate('created_at', $request->get('date'));
            })
            ->with(['productVariantPrices' => function ($q) use ($request) {
                return $q->when($request->get('price_from') && $request->get('price_to'), function ($query) use ($request) {
                    return $query->where('price', '>', $request->get('price_from'))
                        ->where('price', '<', $request->get('price_to'));
                })
                    ->when($request->get('variant'), function ($variantQ) use ($request) {
                        return $variantQ->whereHas('variantOne', function ($query) use ($request) {
                            return $query->where('variant', 'like', '%' . $request->get('variant') . '%');
                        })
                            ->orWhereHas('variantTwo', function ($query) use ($request) {
                                return $query->where('variant', 'like', '%' . $request->get('variant') . '%');
                            });
                    })->with('variantOne', 'variantTwo', 'variantThree');
            }])
            ->paginate(2);
    }

}
