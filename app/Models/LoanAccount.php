<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAccount extends Model
{
    use HasFactory;

    protected $fillable = [
           
            'start_date',
            'end_date',
            'amount',
            'intrest_rate',
            'status',
            'other_info',
            'is_delete',
            'remarks'
    ];

}