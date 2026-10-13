<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CHotelOrder extends Model
{
   
     //  timestamps（created_at 和 updated_at 欄位）
    const CREATED_AT = 'Created_time';
    const UPDATED_AT = null;
    public $timestamps = true; 
    // 指定資料表名稱，默認會使用複數形式 "cashes"
    protected $table = 'c_hotel_order';

    // 指定主鍵欄位名稱，默認是 "id"
    protected $primaryKey = 'Cid';

    // 指定主鍵是否為自動遞增
    public $incrementing = true;

    // 如果主鍵是非整數類型（例如 UUID），可以指定：
    // protected $keyType = 'string';

    

    // 允許批量填充的欄位
    protected $fillable = [
        'Activity','TourDate','HotelDate','GroupName','Target','Customer','Phone','Created_time','Ins','Num','Deposie','DateLine','Discount','Ps','CloseType','S2','T3','T4',
    ];

    // 如果不需要批量填充，可以指定保護欄位
    // protected $guarded = ['id'];
    
  public function getCloseTypeBadgeAttribute()
{
    return match ($this->CloseType) {
        0 => '<span class="badge bg-white text-dark">處理中</span>',
        1 => '<span class="badge bg-warning text-dark">已收訂</span>',
        2 => '<span class="badge bg-success">已完成</span>',
        3 => '<span class="badge bg-danger">已取消</span>',
        default => '<span class="badge bg-light text-dark">未知</span>',
    };
}

   
}



