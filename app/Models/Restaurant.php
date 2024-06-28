<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Type;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = []; 

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
