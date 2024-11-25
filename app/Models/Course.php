<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    /*
    Traits are a functions used in multiple places
    */
    // Those are traits

    use HasFactory, SoftDeletes;
    // To prevent mass assignment error
    protected $fillable = [
        'name',
        'image',
        'content',
        'price',
        'hours',
    ];
}
