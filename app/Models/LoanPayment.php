<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_account_id',
        'paid_amount',
        'intrest_amount', 
        'balance',
        'pay_date',
        'other_info',
        'remarks',
        'status',
        'is_delete',
    ];
}