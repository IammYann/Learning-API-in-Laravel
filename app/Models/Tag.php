<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this line

class Tag extends Model
{
    use HasFactory; // Add this line

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}