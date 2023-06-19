<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApportionmentContributor extends Model
{
    use HasFactory;

    public function apportionments()
    {
        return $this->hasMany(Apportionment::class);
    }

    public function contributors()
    {
        return $this->hasMany(Contributor::class);
    }
}
