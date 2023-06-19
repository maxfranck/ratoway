<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApportionmentProduct extends Model
{
    use HasFactory;

    public function apportionments()
    {
        return $this->hasMany(Apportionment::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
