<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInquiry extends Model
{
    protected $table = 'customer_inquiries';

    protected $fillable = [
        'customer_name',
        'content',
        'phone',
        'salesperson',
        'inquiry_date',
        'note',
    ];
}