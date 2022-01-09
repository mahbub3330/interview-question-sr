<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
      'variant', 'variant_id', 'product_id'
    ];

    public function variantType(): BelongsTo
    {
        return $this->belongsTo(Variant::class, 'variant_id')->withDefault();
    }


}
