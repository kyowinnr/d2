<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOrder  extends Model
{
    use HasFactory;
     // 禁用 timestamps（created_at 和 updated_at 欄位）
    public $timestamps = false;

    // 指定資料表名稱，默認會使用複數形式 "cashes"
    protected $table = 'temporder';

    // 指定主鍵欄位名稱，默認是 "id"
    protected $primaryKey = 'T_ID';

    // 指定主鍵是否為自動遞增
    public $incrementing = true;

    // 如果主鍵是非整數類型（例如 UUID），可以指定：
    // protected $keyType = 'string';

    

    // 允許批量填充的欄位
    protected $fillable = [
        'Name','Location1','Location2','Startdate','Enddate','Number','Ps','CusName1','CusPhone1','CusName2','CusPhone2','sign','Close','PS1','PS2','EndChange','EndTime','OftenId'
    ];

    // 如果不需要批量填充，可以指定保護欄位
    // protected $guarded = ['id'];
    
    
   
}



