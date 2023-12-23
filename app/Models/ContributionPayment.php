<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionPayment extends Model
{
    use HasFactory;
    protected $fillable = [
            'society_member_id',
            'amount',
            'late_fine',
            'pay_date',
            'pay_for_month_year'.
            'status',
            'other_info',
            'is_delete',
    ];
}