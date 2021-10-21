<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class HotelLikeUnlike extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_like_vedio_master';
    protected $fillable = ['id','user_id','hotel_id','vedio_id','like','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','video_category'];
    
	/*like and Unlike Details by UserId */
	
	
	public static function LikeVedioDetailByUserID($uid){
		$query = HotelLikeUnlike::select('ht_hotel_master.id as hotel_id','ht_hotel_master.book_now','ht_hotel_master.hotel_name','ht_hotel_master.promo','ht_hotel_master.profile_img')->join('ht_hotel_master',function($join){
					$join->on('ht_like_vedio_master.hotel_id','=','ht_hotel_master.id');
					$join->where('ht_hotel_master.del_flag','=','N');
		})->where('ht_like_vedio_master.user_id',$uid)->where('ht_like_vedio_master.like',1)->get();
	
		return $query;
			
	}

	
}
