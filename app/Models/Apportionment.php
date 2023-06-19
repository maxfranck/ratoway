<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apportionment extends Model
{
    use HasFactory;

    public function apportionmentProducts()
    {
        return $this->belongsTo(ApportionmentProduct::class);
    }

    public function apportionmentContributors()
    {
        return $this->belongsTo(ApportionmentContributor::class);
    }
}
