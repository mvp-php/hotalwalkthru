<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class WebService extends Model
{
	public static function CheckRegisterByEmail($email){
		$query = DB::table('ht_user_master')->where('email',$email)->where('del_flag','N')->count();
		return $query;
	}
	public static function CheckEmail($email){
		$query = DB::table('ht_user_master')->where('email',$email)->where('del_flag','N')->where('active',1)->first();
		return $query;
	}
	public static function CheckEmailORPassword($email,$password){
		$query = DB::table('ht_user_master')->where('email',$email)->where('password',md5($password))->where('del_flag','N')->where('active',1)->first();
		return $query;
	}
	public static function CheckEmailaddressActiveORNot($email,$password){
		$query = DB::table('ht_user_master')->where('email',$email)->where('password',md5($password))->where('del_flag','N')->where('active',1)->count();
		return $query;
	}
	public static function checkDuplicateEmail($email){
		$query = DB::table('ht_user_master')->where('email',"LIKE",'%'.$email.'%')->where('del_flag','N')->get();
		return $query;
	}
	public static function Signup($fname,$email,$pass,$rand,$country,$gander){
		
		$data = array(
			'full_name'=>$fname,
			'email'=>$email,
			'password'=>md5($pass),
			'active'=>0,
			'country'=>$country,
			'gander'=>$gander,
			'key'=>$rand,
			'created_date'=>date('Y-m-d h:i:s')
		);
		$insert = DB::table('ht_user_master')->InsertGetId($data);
		return $insert;
	}
	
	public static function forgot_passwordUpdate($id,$otp){
		$insert = DB::table('ht_user_master')->where('id',$id)->update(array('otp'=>$otp));
		return $insert;
		
	}
	
	public static function checkOtp($user_id,$otp){
		$query = DB::table('ht_user_master')->select('id','full_name','email')->where('id',$user_id)->where('otp',$otp)->where('del_flag','N')->get();
		return $query;
	}
	public static function checkVerifyByKey($key){
		$query  = DB::table("ht_user_master")->where("key",'=',  $key)->where("del_flag",'=', 'N')->count();
		return $query;
	}
	public static function GetDetailsByKey($key){
		$query = DB::table("ht_user_master")->where(array("key" => $key))->first();
		return $query;
	}
	
	public static function ResetPassword($id,$password){
		$insert = DB::table('ht_user_master')->where('id',$id)->update(array('password'=>md5($password),'otp'=>''));
		return $insert;
		
	}
   
	public static function hotelProfileImageByHotelId($id){
		$query = DB::table('ht_hotel_image_master')->where('del_flag','N')->where('hotel_id',$id)->get();
		return $query;
	}
	public static function hotelVideoHotelId($id){
		$query = DB::table('ht_video_master')->where('del_flag','N')->where('hotel_id',$id)->get();
		return $query;
	}
}
