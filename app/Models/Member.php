<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
            'user_id',
            'parent_id',
            'reference_id',
            'sub_reference_id',
            'name',
            'city',
            'state',
            'address1',
            'address2',
            'pincode',
            'guardian',
            'gender',
            'email',
            'phone',
            'password',
            'other_info',
            'other_info2',
            'adhar_card_url',
            'photo_url',
            'remarks',
            'status',
    ];
}
