<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'OrderId';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeDepartureDate($query, $date)
    {
        return $query->whereDate('OrderStart', $date);
    }


    public function tmCustomer()
    {
        return $this->hasOne(Customer::class, 'OrderId', 'OrderId')
            ->where('TM', 1);
    }
}