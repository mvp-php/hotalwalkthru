<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class HotelPrice extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_hotel_price_master';
    protected $fillable = ['id','hotel_id','title','price','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','active','otp','key'];
   
	/*web service function */
	public static function getPriceByHotelId($hotel_id){
		$query = HotelPrice::select('id as PriceId','title','price')->where('del_flag','N')->where('hotel_id',$hotel_id)->get();
		return $query;
		
	}
	
	/*end web service function */
}
