<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'code',
            'start_date',            
            'contact_person',
            'contact_no',            
            'city',
            'state',
            'address1',
            'address2',            
            'pin_code',
            'status',
            'remarks',
            'other_info1',
            'other_info2',
            'logo_url',
            'image_url',
    ];
}

