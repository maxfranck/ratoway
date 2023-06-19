<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'flavor', 'description', 'size', 'pieces', 'image', 'price'];
    public function apportionmentProducts()
    {
        return $this->belongsTo(ApportionmentProduct::class);
    }
}
