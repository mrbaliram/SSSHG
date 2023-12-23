<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society_rule extends Model
{
    use HasFactory;

     protected $fillable = [
            'society_id',
            'title',
            'sort_desc',
            'long_desc',
            'status',
            'is_delete',
    ];
}
