<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class HotelView extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_hotel_view';
    protected $fillable = ['id','user_id','hotel_id','category_id','video_id', 'like','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
    
	
}
