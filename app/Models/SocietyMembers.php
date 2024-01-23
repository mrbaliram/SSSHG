<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocietyMembers extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'society_member_id',
            'account_number',
            'name',
            'mobile',
            'type',
            'remarks',
            'message',
            'other_info1',
            'other_info2',
            'status',            
            'is_delete',
    ];
}
