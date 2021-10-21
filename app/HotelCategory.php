<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class HotelCategory extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_hotel_category';
    protected $fillable = ['id','hotel_id','category_id','view_count','like_count', 'del_flag'];
}
