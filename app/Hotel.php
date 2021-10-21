<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_hotel_master';
    protected $fillable = ['id','full_name','email','password','hotel_name', 'address','country','state','city','location','mobile','zipcode','price','profile_img','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','active','otp','key','social_id','social_type','view_count','like_count','book_now'];
    
	/*This function Web service included */
	public static function hotelList(){
        $query = Hotel::where("del_flag",'N')->where('promo','!=',null)->orderBy('id','Desc')->get();
        return $query;
    } 
	/*This function Web service included */
    public static function viewHotelById($id){
        $query = Hotel::where("del_flag",'N')->where('id',$id)->first();
        return $query;
    }

    
	/*web service call function start */
	public static function checkHotelDuplicateEmail($email){
		$query = Hotel::where('email',"LIKE",'%'.$email.'%')->where('del_flag','N')->get();
		return $query;
	}
	
	public static function HotelSignUp($full_name,$email,$password,$rand){
		$data_array= array(
			'full_name'=>$full_name,
			'email'=>$email,
			'password'=>md5($password),
			'key'=>$rand,
			'created_date'=>date('Y-m-d h:i:s'),
			
		);
		$insert = new Hotel($data_array);
		$insert->save();
		$insert_id = $insert->id;
		return $insert_id;
	}
	
	public static function checkVerifyByKey($key){
		
		$query  = Hotel::where("key",'=',  $key)->where("del_flag",'=', 'N')->count();
		return $query;
	}
	
	public static function checkHotelRegisterByEmail($email){
		$query =Hotel::where('email',$email)->where('del_flag','N')->count();
		return $query;
	}
	public static function checkHotelEmailORPassword($email,$password){
		$query = Hotel::where('email',$email)->where('password',md5($password))->where('del_flag','N')->where('active',1)->first();
		return $query;
	}
	public static function checkHotelEmailActiveORNot($email,$password){
		$query =  Hotel::where('email',$email)->where('password',md5($password))->where('del_flag','N')->where('active',1)->count();
		return $query;
	}
	
	public static function checkHotelEmail($email){
		
		$query = Hotel::where('email',$email)->where('del_flag','N')->where('active',1)->first();
		return $query;
	}
	
	public static function EditProfileById($user_id){
		$query = Hotel::select('id','full_name','email','hotel_name','address','mobile','opening_hours','profile_img','book_now')->where('id',$user_id)->first();	
		return $query;
	}
	/*End web service call function */
	
}
