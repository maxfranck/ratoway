<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    use HasFactory;

    public function apportionmentContributors()
    {
        return $this->belongsTo(ApportionmentContributor::class);
    }
}
