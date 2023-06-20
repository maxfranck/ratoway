<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apportionment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function apportionmentProducts()
    {
        return $this->belongsTo(ApportionmentProduct::class);
    }

    public function contributors()
    {
        return $this->hasMany(Contributor::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'apportionment_products')
            ->withPivot('quantity');
    }
}
