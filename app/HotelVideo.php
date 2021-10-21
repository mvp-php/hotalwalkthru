<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class HotelVideo extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_video_master';
    protected $fillable = ['id','hotel_id','url','category_fk','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','view_count','like_count'];
   
	/*web service function */
	public static function userSideHotelVideo($hotel_id,$cid){
		$query = HotelVideo::select('id','url','hashtag')->where('hotel_id',$hotel_id)->where('category_fk',$cid)->get();
		return $query;
		
	}
	
	/*end web service function */
	public static function AllDetailsByHotelId($hotel_id,$cid){
		$query = HotelVideo::select('*')->where('hotel_id',$hotel_id)->where('category_fk',$cid)->where('del_flag','N')->get();
		return $query;
	}
	public static function getSixTrendingVideo($hotel_id){
		$query = HotelVideo::select('*')->where('hotel_id',$hotel_id)->limit('6')->orderBy('view_count','desc')->get();
		return $query;
	}
	public static function getSixRecentVideo($hotel_id){
		$query = HotelVideo::select('*')->where('hotel_id',$hotel_id)->limit('6')->orderBy('id','desc')->get();
		return $query;
	}
}
