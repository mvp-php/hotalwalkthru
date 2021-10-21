<?php 
namespace App\Http\Controllers\API\v1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\WebService;
use App\EmailTemplate;
use App\Hotel;
use App\HotelPrice;
use Mail;
use URL;
use DB;
use App\Category;
use App\HotelLikeUnlike;
use App\HotelVideo;
use App\HotelView;
use App\HotelCategory;
use App\Customer;
use App\Country;
use App\FollowUnfollow;
use App\Slider;
use App\VideoHashtag;
use Illuminate\Support\Facades\Input;

class ServiceController extends Controller 
	{
		public $successStatus = 200;
	
		public function signup(){
			$full_name = Input::post('full_name');
			$country = Input::post('country');
			$gender = Input::post('gender');
			$full_name = Input::post('full_name');
			$email = Input::post('email');
			$password = Input::post('password');
		
			if($full_name !='' && $email !='' && $password !=''){
				/** check duplicate email address **/
				$checkDuplicate = WebService::checkDuplicateEmail($email);
				
				if(count($checkDuplicate) >0){
					return response()->json(["status"=>"0",'msg' => "Email address already exists.","data"=>array()]);
					die();
				}	
				/***end code of duplicate email address **/
				/*** check password lenght minimum six character allowed**/
				if(strlen($password) < 6){
					return response()->json(["status"=>"0",'msg' => "Password atleast six character allowed.","data"=>array()]);
					die();
				}
				
				/****end code of duplicate email address**/
				$rand = rand(000000,999999);
				$singup= WebService::Signup($full_name,$email,$password,$rand,$country,$gender);
				if($singup){
					$emailId= 1;
					 $query = EmailTemplate::GetEmailTemplate($emailId);
                        $subject = $query->subject;
                        $body = $query->mail;
                        $url = URL::to('/');
					
                        $link = URL::to('/') . "/api/v1/verify_account/" . $rand;
                        $logo = URL::to('/') . 'Hotel';
                        $body = str_replace('{{url}}', $url, $body);
                        $body = str_replace('{{logo}}', $logo, $body);
                        $body = str_replace('{{NAME}}', $full_name ,$body);
                        $body = str_replace('{{link}}', $link, $body);
                        $maildata = array(
                            "name" => $full_name,
                            "email" => $email,
                            "subject" => $subject
                        );

                        Mail::send('include.mail', ['mail' => $body], function($message) use ($maildata) {
                            $message->from("noreplay@workdemo.xyz", "Hotel");
                            $message->to($maildata['email'], $maildata['name']);
                            $message->subject($maildata['subject']);
                        });
					$data =array(
						'id'=>$singup
					);
					return response()->json(["status"=>"1",'msg' => "Register successfully inserted. please check email address.","data"=>array($data)]);
				}else{
						return response()->json(["status"=>"0",'msg' => "sorry.","data"=>array()]);
				}
			}else{
				return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
			}
		}
		
		/** 
		 * verify account after register
		 * 
		 * 
		 */ 
		
		public function verify_account(Request $request){
			$key = $request->segment(4);
			/** start code verification key **/ 
				$row = WebService::checkVerifyByKey($key);
			/**end **/
			if ($row != 0) {
				/*get Details after verification */
				$query = WebService::GetDetailsByKey($key);
					$active =Customer::where(array("id" => $query->id))->update(array("key" => "", "active" => 1));
					if ($active) {
						return view("login_mail");
					} else {
						return response()->json(['status' => "0", 'msg' => "Try Again!", 'data' => array()]);
					}
				}else {
					return response()->json(['status' => "0", 'msg' => "Invalid verification key", 'data' => array()]);
				}
		}
		
		/** 
		 * login api 
		 * 
		 * 
		 */ 
		
		
		public function login(Request $request){ 
			$email = Input::post('email');
			$password = Input::post('password');
			if($email !='' && $password !=''){
				$reqister_email = WebService::CheckRegisterByEmail($email);
		
				if($reqister_email !=0){
					$checkLoginOrNot= WebService::CheckEmailORPassword($email,$password);
					
					if($checkLoginOrNot !=''){ 
						$result = WebService::CheckEmailaddressActiveORNot($email,$password);
						
						if($result ==1){
							$response = Customer::where('email',$email)->where('password',md5($password))->where('del_flag','N')->where('active',1)->first();
							$response->id = $response->id.'';	
							return response()->json(['status' => "1", 'msg' => "Login success", 'data' => array($response)]);
						}else{
							return response()->json(["status"=>0,'msg' => "Please active account..","data"=>array()]);
						}
					}else{
						return response()->json(["status"=>0,'msg' => "Invalid emailaddress and password.","data"=>array()]);
					}
					
				}else{
					return response()->json(["status"=>0,'msg' => "Please create account first.","data"=>array()]);
				}
			}else{ 
			 return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);

			} 
		}
		/** 
		 * get Details User edit Profile by id 
		 * 
		 * 
		 */ 
	
	public function userEditProfileById(){
		$user_id = Input::get('user_id');
		if($user_id !=''){
			$query = Customer::where('id',$user_id)->first();
			$countryName = '';
			if(isset($query->country) && $query->country !=''){
				$getCountry = Country::select('country_name')->where('id',$query->country)->where('del_flag','N')->first();
				$countryName =$getCountry->country_name; 
			}
			$query->countryName = $countryName;
			if($query !=''){
					return response()->json(["status"=>"1",'msg' => "Success","data"=>array($query)]);
			}else{
				return response()->json(["status"=>"0",'msg' =>"No record available","data"=>array()]);
			}
			
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	
	/** 
		 *Update User profile and details by id
		 * 
		 * 
		 */ 
	
	public function updateUserById(){
		$user_id = Input::post('user_id');
		$full_name = Input::post('full_name');
		$email = Input::post('email');
		$mobile = Input::post('mobile');
		$gender = Input::post('gender');
		$country = Input::post('country');
		$profile_img = Input::file('profile_img');

		
		if($user_id !=''){
				if($user_id !='' && $full_name !='' && $email !='' ){
					$checkEmail = Customer::where('email','LIKE','%'.$email.'%')->where('id','!=',$user_id)->count();
					if($checkEmail !=0){
						return response()->json(['status'=>'0','msg'=>'Email already exist.','data'=>array()]);die();
					}
					
					$UserDetails = array(
						'full_name'=>$full_name,
						'email'=>$email,
						'gander'=>$gender,
						'country'=>$country
					);
					if($mobile !=''){
						$UserDetails['mobile'] = $mobile;
					}
					if($profile_img !=''){
				
                    
						$photo = time().'.'.$profile_img->getClientOriginalExtension();
						$destinationPath = public_path('/upload/');
						$profile_img->move($destinationPath, $photo);
                		$UserDetails['profile_img'] = $photo;
					}
				
					$update = Customer::where('id',$user_id)->update($UserDetails);
					$getUserDetail = Customer::where('id',$user_id)->first();
					return response()->json(['status'=>'1','msg'=>'success.','data'=>array($getUserDetail)]);
					
				}else{
					return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
				}
		}else{
			
			return response()->json(["status"=>"0",'msg' => 'Please Login','data'=>array()]);
		}
		
		
		
	}
	public function forgot_password(){
		$email = Input::post('email');
		if($email !=''){
			$query = WebService::CheckEmail($email);
			if($query !=null){
				$otp =rand(0000,9999);
				$update= WebService::forgot_passwordUpdate($query->id,$otp);
				if($update){
					
					/** Mail code */
					$emailId=2;
					 $query = EmailTemplate::GetEmailTemplate($emailId);
					 $user_data = Customer::where(array('email' => $email))->first();

				$subject = $query->subject;
				$body = $query->mail;

				$url = URL::to('/');

				$logo = 'Hotel';
				$body = str_replace('{{url}}', $url, $body);
				$body = str_replace('{{logo}}', $logo, $body);
				$body = str_replace('{{NAME}}', $user_data->full_name , $body);
				$body = str_replace('{{KEY}}', $otp, $body);
				$maildata = array(
					"name" => $user_data->full_name,
					"email" => $email,
					"subject" => $subject
				);
				try {
					Mail::send('include.mail', ['mail' => $body], function($message) use ($maildata) {
						$message->from("noreplay@workdemo.com", "Hotel");
						$message->to($maildata['email'], $maildata['name']);
						$message->subject($maildata['subject']);
					});
				} catch (Exception $e) {
					//echo 'Message: ' .$e->getMessage();
				}
				
					/**End mail code **/
					$otp = array("user_id"=>$user_data->id,"otp"=>$otp);
					return response()->json(["status"=>"1",'msg' => "Success","data"=>array($otp)]);
				}else{
					return response()->json(["status"=>"0",'msg' => "Sorry","data"=>array()]);
				}
				
			}else{
				return response()->json(["status"=>0,'msg' => "Please check email address.","data"=>array()]);
			}
		}else{ 
		 return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);

		} 
	}
	public function verify_otp(){
		$user_id = Input::post('user_id');
		$otp = Input::post('otp');
		if($user_id !='' && $otp !=''){
			$checkOtp = WebService::checkOtp($user_id,$otp);
			if(count($checkOtp) >0){
		
				return response()->json(["status"=>"1",'msg' => "Success","data"=>$checkOtp->toArray()]);
			}else{
				return response()->json(["status"=>"0",'msg' => "Invalid otp","data"=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	
	public function resend_otp(){
		$email = Input::post('email');
		if($email !=''){
			$query = WebService::CheckEmail($email);
			if($query !=null){
				$otp =rand(0000,9999);
				$update= WebService::forgot_passwordUpdate($query->id,$otp);
				if($update){
					
					/** Mail code */
					
					/**End mail code **/
					$resendOtp = array("otp"=>$otp);
					return response()->json(["status"=>"1",'msg' => "OTP","data"=>array($resendOtp)]);
				}else{
					return response()->json(["status"=>"0",'msg' => "Sorry","data"=>array()]);
				}
				
			}else{
				return response()->json(["status"=>0,'msg' => "Please check email address.","data"=>array()]);
			}
		}else{ 
		 return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);

		} 
	}
		
	public function reset_password(){
		$user_id= Input::post('user_id');
		$password = Input::post('password');
		
		if($user_id !='' && $password !=''){
			$updatePassword = WebService::ResetPassword($user_id,$password);
			if($updatePassword){
				return response()->json(["status"=>"1",'msg' => "Password successfull changed","data"=>array(array('user_id'=>$user_id))]);
			}else{
				return response()->json(["status"=>"0",'msg' => "Sorry","data"=>array()]);
			}
			
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	
	public function hotel_list(){
		$user_id = Input::get('user_id');
		if($user_id !=''){
			$query = Hotel::hotelList();
			if(count($query) > 0){
				foreach($query as $val){
					
						$val->bookNow = $val->book_now;	
						$likeStatus =HotelLikeUnlike::select('like')->where('hotel_id',$val->id)->where('user_id',$user_id)->first();
						$likes='0';
						if(isset($likeStatus->like) && $likeStatus->like !=''){
							$likes = $likeStatus->like;	
						}
						$val->linkunlikestatus = $likes;
						$getCategory = DB::table('ht_category_master')->select('id','category_name')->where('del_flag','N')->get();
						if(isset($getCategory) && $getCategory !=''){
							foreach($getCategory as $vals){
								/*user Side hotel video category */
								$getVideoByCategory = HotelVideo::userSideHotelVideo($val->id,$vals->id);
								foreach($getVideoByCategory as $videoList){
								$getVideoByHashtag = VideoHashtag::where('video_fk',$videoList->id)->where('type','video')->get();
									if(count($getVideoByHashtag) > 0){
										$videoList->hashtag = $getVideoByHashtag;
									}
								}
								$vals->Video = $getVideoByCategory;
								//$vals->Video = $getVideoByCategory;
								
								/*End  */
							}
						}
						$val->hotel_videos =$getCategory; 
					
				}
				return response()->json(["status"=>'1','message' => 'Success','data'=>$query->toArray()],$this-> successStatus);
				
			}else{
				return response()->json(["status"=>"0",'message' => 'No record available','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'message' => 'Parameter Required','data'=>array()]);
		}
	}
	public function hotelDetailsById(){
		$user_id = Input::get('user_id');
		$hotel_id = Input::get('hotel_id');
		if($user_id !='' && $hotel_id !=''){
			$final_array = array();
			$query = Hotel::viewHotelById($hotel_id);
			$query->book_now = $query->book_now;
			$total_view = $query->view_count+1;
			$update  = Hotel::where('id',$hotel_id)->update(array('view_count'=>$total_view));
			$insert = new HotelView(array('hotel_id'=>$hotel_id,'user_id'=>$user_id));
					$insert->save();
			
			if($query !=''){
				$query->view_count = $total_view;
				$HotelImages = WebService::hotelProfileImageByHotelId($hotel_id);
				$query->hotelProfile =$HotelImages;
				$getCategory = DB::table('ht_category_master')->select('id','category_name')->where('del_flag','N')->get();
				if(isset($getCategory) && $getCategory !=''){
					foreach($getCategory as $vals){
						$getVideoByCategory = HotelVideo::userSideHotelVideo($hotel_id,$vals->id);
						$vals->Video = $getVideoByCategory;
					}
				}
				$query->HotelVideo =$getCategory; 
				$checkFollowUnfollow = FollowUnfollow::where('user_id',$user_id)->where('hotel_id',$hotel_id)->where('follow_unfollow','follow')->where('del_flag','N')->first();
				$query->follow =""; 
				if($checkFollowUnfollow){
					$query->follow ="Yes"; 
				}
				
				
				$final_array[] = $query;
				
				return response()->json(["status"=>'1','message' => 'Success','data'=>$final_array],$this-> successStatus);
			}else{
				return response()->json(["status"=>"0",'message' => 'No record available','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'message' => 'Parameter Required','data'=>array()]);
		}
	}

	public function LikeVedioDetailByUserID(){
		$user_id = Input::get('user_id');
		if($user_id !=''){
			$query = HotelLikeUnlike::LikeVedioDetailByUserID($user_id);
			if(count($query) >0){
				foreach($query as $val){
					$likeStatus =HotelLikeUnlike::select('like')->where('hotel_id',$val->hotel_id)->where('user_id',$user_id)->first();
					$likes='0';
					if(isset($likeStatus->like) && $likeStatus->like !=''){
						$likes = $likeStatus->like;	
					}
					$val->bookNow = $val->book_now;	
					$val->linkunlikestatus = $likes.'';
				}
				return response()->json(["status"=>"1",'message' => 'success','data'=>$query]);
			}else{
				return response()->json(["status"=>"0",'message' => 'No record available','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'message' => 'Parameter Required','data'=>array()]);
		}
	}
	public function social_login(Request $request) {
		$social_id = Input::post('social_id');
        $social_type = Input::post('social_type');
        $first_name = Input::post('first_name');
        $last_name = Input::post('last_name');
        $email = Input::post('email');
        $password = Input::post('password');
       if ($social_id != '' && $social_type !='' && $first_name !='' )  {
		     $number = Customer::where(array("social_id" => $social_id, "social_type" => $social_type, "del_flag" => 'N', "active" => '1'))->count();
	//	   date_default_timezone_set("UTC");
            $time1 = date("Y-m-d h:i:s");
		   	if($number ==0){
				
				 $data = array(
                    "full_name" => $first_name.' '.$last_name,
                   
                    "social_id" => $social_id,
                    "social_type" => $social_type,
                    "created_date" => $time1,
                    "active" => 1,
                    "email" => $email
                );
				$insert = Customer::insertGetId($data);  
				$data = Customer::where('id',$insert)->where('active',1)->where('del_flag','N')->first();
				return response()->json(['status' => "1", 'msg' => "success", 'data' => array($data)]);
			}else{
				$row = Customer::where(array("social_id" => $social_id, "social_type" => $social_type))->first();
				 $data = array(
                    "full_name" => $first_name.' '.$last_name,
                    "active" => 1
                );
                if ($email != '') {
                    $data['email'] = $email;
                }
				Customer::where(array('id' => $row->id))->update($data);
				$data = Customer::where('id',$row->id)->where('active',1)->where('del_flag','N')->first();
					 return response()->json(['status' => "1", 'msg' => "success", 'data' => array($data)]);
			}
		   
	   }else{
		   return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
	   }
		
	}
	public function viewVideoByIds(){
		$user_id = Input::get('user_id');
		$video_id = Input::get('video_id');
		if($user_id !='' && $video_id !=''){
			$getCategoryIdByVideoId = HotelVideo::where('id',$video_id)->where('del_flag','N')->first();
			$ViewCountByCategoryId = HotelCategory::select('view_count')->where('category_id',$getCategoryIdByVideoId->category_fk)->where('hotel_id',$getCategoryIdByVideoId->hotel_id)->where('del_flag','N')->first();
			$totalCounts = 0;
			if($ViewCountByCategoryId !=''){
				$totalCounts=$ViewCountByCategoryId->view_count;
				
			}
			$totalCount =$totalCounts+1;
			if($ViewCountByCategoryId ==''){
				$insert = new HotelCategory(array('category_id'=>$getCategoryIdByVideoId->category_fk,'hotel_id'=>$getCategoryIdByVideoId->hotel_id,'view_count'=>$totalCount,'created_date'=>date('Y-m-d h:i:s')));
				$insert->save();
				$update = $insert->id;
			}else{
				$update = HotelCategory::where('category_id',$getCategoryIdByVideoId->category_fk)->where('hotel_id',$getCategoryIdByVideoId->hotel_id)->update(array('view_count'=>$totalCount));
			}
			/*update view count by category id */
			
			$TotalVideoCount = $getCategoryIdByVideoId->view_count+1;
			$update = HotelVideo::where('id',$video_id)->update(array('view_count'=>$TotalVideoCount));
			
			$insert = new HotelView(array('user_id'=>$user_id,'hotel_id'=>$getCategoryIdByVideoId->hotel_id,'category_id'=>$getCategoryIdByVideoId->category_fk,'video_id'=>$video_id));
					  $insert->save();
			/*End update view count by category id*/
			if($update){
				return response()->json(['status' => "1", 'msg' => "success", 'data' => array()]);
			}else{
				return response()->json(["status"=>"0",'message' => 'No record available','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
		
	}
	/*end User side services */
	/*hotel Services */
	public function Hotelsignup(){
		$full_name = Input::post('full_name');
		$email = Input::post('email');
		$password = Input::post('password');
		
		if($full_name !='' && $email !='' && $password !=''){
			/** check duplicate email address **/
			$checkDuplicate = Hotel::checkHotelDuplicateEmail($email);
			
			if(count($checkDuplicate) >0){
				return response()->json(["status"=>"0",'msg' => "Email address already exists.","data"=>array()]);
				die();
			}	
			/***end code of duplicate email address **/
			/*** check password lenght minimum six character allowed**/
			if(strlen($password) < 6){
				return response()->json(["status"=>"0",'msg' => "Password atleast six character allowed.","data"=>array()]);
				die();
			}
			
			/****end code of duplicate email address**/
			$rand = rand(000000,999999);
			$singup= Hotel::HotelSignUp($full_name,$email,$password,$rand);
			if($singup){
				$emailId= 1;
				 $query = EmailTemplate::GetEmailTemplate($emailId);
					$subject = $query->subject;
					$body = $query->mail;
					$url = URL::to('/');
				
					$link = URL::to('/') . "/api/v1/hotelverify_account/" . $rand;
					$logo = URL::to('/') . 'Hotel';
					$body = str_replace('{{url}}', $url, $body);
					$body = str_replace('{{logo}}', $logo, $body);
					$body = str_replace('{{NAME}}', $full_name ,$body);
					$body = str_replace('{{link}}', $link, $body);
					$maildata = array(
						"name" => $full_name,
						"email" => $email,
						"subject" => $subject
					);

					Mail::send('include.mail', ['mail' => $body], function($message) use ($maildata) {
						$message->from("noreplay@workdemo.xyz", "Hotel");
						$message->to($maildata['email'], $maildata['name']);
						$message->subject($maildata['subject']);
					});
				$data =array(
					'id'=>$singup
				);
				return response()->json(["status"=>"1",'msg' => "Hotel register successfully inserted. please check email address.","data"=>array($data)]);
			}else{
					return response()->json(["status"=>"0",'msg' => "sorry.","data"=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
		
	/** 
	 * verify account after register
	 * 
	 * 
	 */ 
		
	public function hotelVerifyAccount(Request $request){
		$key = $request->segment(4);
		/** start code verification key **/ 
			$row = Hotel::checkVerifyByKey($key);
		/**end **/
		if ($row != 0) {
			/*get Details after verification */
			$query = Hotel::select('id')->where('key',$key)->first();
				$active = Hotel::where(array("id" => $query->id))->update(array("key" =>null, "active" => 1));
				if ($active) {
					return view("login_mail");
				} else {
					return response()->json(['status' => "0", 'msg' => "Try Again!", 'data' => array()]);
				}
			}else {
				return response()->json(['status' => "0", 'msg' => "Invalid verification key", 'data' => array()]);
			}
	}
	/** 
	 *Hotel  login api 
	 * 
	 * 
	 */ 
	public function hotelLogin(Request $request){ 
		$email = Input::post('email');
		$password = Input::post('password');
		if($email !='' && $password !=''){
			$reqister_email = Hotel::checkHotelRegisterByEmail($email);
	
			if($reqister_email !=0){
				$checkLoginOrNot= Hotel::checkHotelEmailORPassword($email,$password);
				
				if($checkLoginOrNot !=''){ 
					$result = Hotel::checkHotelEmailActiveORNot($email,$password);
					
					if($result ==1){
						$response = Hotel::select('*')->where('email',$email)->where('password',md5($password))->where('del_flag','N')->where('active',1)->first();
						
						return response()->json(['status' => "1", 'msg' => "Login success", 'data' => array($response)]);
					}else{
						return response()->json(["status"=>"0",'msg' => "Please active account..","data"=>array()]);
					}
				}else{
					return response()->json(["status"=>"0",'msg' => "Invalid email address and password.","data"=>array()]);
				}
				
			}else{
				return response()->json(["status"=>"0",'msg' => "Please create account first.","data"=>array()]);
			}
		}else{ 
		 return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);

		} 
	}
		
	/** 
	 * Forgot password by email address
	 * 
	 * 
	 */ 
	public function hotelForgotPassword(){
		$email = Input::post('email');
		if($email !=''){
			$query = Hotel::checkHotelEmail($email);
			if($query !=null){
				$otp =rand(0000,9999);
				$update= Hotel::where('id',$query->id)->update(array('otp'=>$otp));
				if($update){
					/** Mail code */
					$emailId=2;
					 $query = EmailTemplate::GetEmailTemplate($emailId);
					 $user_data = Hotel::where(array('email' => $email))->first();

					$subject = $query->subject;
					$body = $query->mail;

					$url = URL::to('/');

					$logo = 'Hotel';
					$body = str_replace('{{url}}', $url, $body);
					$body = str_replace('{{logo}}', $logo, $body);
					$body = str_replace('{{NAME}}', $user_data->full_name , $body);
					$body = str_replace('{{KEY}}', $otp, $body);
					$maildata = array(
						"name" => $user_data->full_name,
						"email" => $email,
						"subject" => $subject
					);
				
					try {
						Mail::send('include.mail', ['mail' => $body], function($message) use ($maildata) {
							$message->from("noreplay@workdemo.com", "Hotel");
							$message->to($maildata['email'], $maildata['name']);
							$message->subject($maildata['subject']);
						});
						
					} catch (Exception $e) {
						echo 'Message: ' .$e->getMessage();
					}
					/**End mail code **/
					$otp = array("user_id"=>$user_data->id,"otp"=>$otp);
					return response()->json(["status"=>"1",'msg' => "Success","data"=>array($otp)]);
				}else{
					return response()->json(["status"=>"0",'msg' => "Sorry","data"=>array()]);
				}
			}else{
				return response()->json(["status"=>0,'msg' => "Please check email address.","data"=>array()]);
			}
		}else{ 
		 return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		} 
	}
	/** 
	 * Verify otp by id
	 * 
	 * 
	 */ 
	public function hotelVerifyOtpById(){
		$user_id = Input::post('user_id');
		$otp = Input::post('otp');
		if($user_id !='' && $otp !=''){
			$checkOtp = Hotel::select('id','full_name','email')->where('id',$user_id)->where('otp',$otp)->where('del_flag','N')->first();
			if($checkOtp !=''){
		
				return response()->json(["status"=>"1",'msg' => "Success","data"=>array($checkOtp)]);
			}else{
				return response()->json(["status"=>"0",'msg' => "Invalid otp","data"=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
		
	/** 
	 *Hotel Reset Password
	 * 
	 * 
	 */ 
		
	public function hotelResetPassword(){
		$user_id= Input::post('user_id');
		$password = Input::post('password');
		
		if($user_id !='' && $password !=''){
			$updatePassword = Hotel::where('id',$user_id)->update(array('password'=>md5($password)));
			if($updatePassword){
				return response()->json(["status"=>"1",'msg' => "Password successfull changed","data"=>array(array('user_id'=>$user_id))]);
			}else{
				return response()->json(["status"=>"0",'msg' => "Sorry","data"=>array()]);
			}
			
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	
	/***
	*
	*Hotel category list
	*/
	public function categoryList(){
		$query = Category::select('id','category_name')->where('del_flag','N')->get();
		if(isset($query) && $query !=''){
			return response()->json(["status"=>"1",'msg' => "success","data"=>$query->toArray()]);
			
		}else{
				return response()->json(["status"=>"0",'msg' => "No record available","data"=>array()]);
			}
		
	}
	
	/** 
	 * get Details Hotel edit Profile by id 
	 * 
	 * 
	 */ 
	
	public function hotelEditProfileById(){
		$user_id = Input::get('user_id');
		if($user_id !=''){
			$query = Hotel::EditProfileById($user_id);
			
			$final_array =array();
			if($query !=''){
				$final_array['basicDetail'] = $query;
				$priceByHotelId = HotelPrice::getPriceByHotelId($user_id);
				if(isset($priceByHotelId) && $priceByHotelId !=''){
					$final_array['priceDetials'] = $priceByHotelId;
				}
				
			}
			if($final_array !=null){
					return response()->json(["status"=>"1",'msg' => "Success","data"=>array($final_array)]);
			}else{
				return response()->json(["status"=>"0",'msg' =>"No record available","data"=>array()]);
			}
			
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	/** 
		 *Update Hotel profile and details by id
		 * 
		 * 
		 */ 
	
	public function updateHotelById(){
		$user_id = Input::post('user_id');
		$full_name = Input::post('full_name');
		$email = Input::post('email');
		$hotel_name = Input::post('hotel_name');
		$address = Input::post('address');
		$phone = Input::post('phone');
		$open_hours = Input::post('open_hours');
		$json_prices = Input::post('prices');
		$profile_img = Input::file('profile_img');
		$book_now = Input::post('book_now');
		$price = json_decode($json_prices,true);
		if($user_id !=''){
				if($user_id !='' && $full_name !='' && $email !='' && $hotel_name !='' && $address !='' && $phone !='' && $book_now !=''){
					$hotelDetails = array(
						'full_name'=>$full_name,
						'email'=>$email,
						'hotel_name'=>$hotel_name,
						'address'=>$address,
						'mobile'=>$phone,
						'book_now'=>$book_now
					);
					if($open_hours !=''){
						$hotelDetails['opening_hours']=$open_hours;
					}
					if($profile_img !=''){
				
                    
						$photo = time().'.'.$profile_img->getClientOriginalExtension();
						$destinationPath = public_path('/upload/');
						$profile_img->move($destinationPath, $photo);
                		$hotelDetails['profile_img'] = $photo;
					}
				
					$update = Hotel::where('id',$user_id)->update($hotelDetails);
					$getResponse = Hotel::where('id',$user_id)->first();
					return response()->json(['status'=>'1','msg'=>'success.','data'=>array($getResponse)]);
					
				}else{
					return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
				}
		}else{
			
			return response()->json(["status"=>"0",'msg' => 'Please Login','data'=>array()]);
		}
		
		
		
	}
	/*end Hotel Services */
	
	/** 
	*Update Hotel profile and details by id
	* 
	* 
	*/
	public function hotelWiseUploadImageVedio(){
		ini_set('memory_limit', '2048M');
		$user_id = Input::post('user_id');
		$type = Input::post('type');
		$category_id = Input::post('category_id');
		$file = Input::file('file');
		$hashtag = Input::post('hashtag');
		if($user_id !=''){
			if($user_id !='' && $type !='' && $category_id !='' && $file !=''){
				if($file !=''){
                    $photo = time().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/image/');
                    $file->move($destinationPath, $photo);
                }
				if($type =='image'){
					$insert = DB::table('ht_hotel_image_master')->insertGetId(array('hotel_id'=>$user_id,'category_id'=>$category_id,'image'=>$photo,'created_date'=>date('Y-m-d h:i:s')));
					$msg= 'Image';
				}else{
					$Data_array = array('hotel_id'=>$user_id,'category_fk'=>$category_id,'url'=>$photo,'created_date'=>date('Y-m-d h:i:s'));
					$insertid = new  HotelVideo($Data_array);
					$insertid->save();
					$insert =$insertid->id; 
					$msg= 'Vedio';
				}
				if($insert){
					if($hashtag != ""){
						$hashtagArray = explode(",",$hashtag);
						if(count($hashtagArray) > 0){
							foreach($hashtagArray as $hashtagName){
								$insertHashtagArray = array("video_fk"=>$insert,"type"=>"video","hashtag"=>$hashtagName,"created_at"=>date('Y-m-d H:i:s'),"created_by"=>$user_id);
								$inserthashtag = new  VideoHashtag($insertHashtagArray);
								$inserthashtag->save();
								$inserthashtag->id;
							}
						}
					}
					return response()->json(['status'=>'1','msg'=>$msg.' success uploaded.','data'=>array('id'=>$insert)]);
				}else{
					return response()->json(['status'=>'0','msg'=>'Sorry, something went wrong. Please try again.','data'=>array()]);
				}
			}else{
				return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Please Login','data'=>array()]);
		}
	}
	/** 
	*Update Hotel profile and details by id
	* 
	* 
	*/
	public function hotelWisePromoVedio(){
		ini_set('memory_limit', '2048M');
		$user_id = Input::post('user_id');
		$file = Input::file('file');
		$hashtag = Input::post('hashtag');
		if($user_id !=''){
			if($user_id !='' && $file !=''){
				if($file !=''){
                    $photo = time().'.'.$file->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/image/');
                    $file->move($destinationPath, $photo);
                }
				$insert = Hotel::where('id',$user_id)->update(array('promo'=>$photo));
				if($insert){
					if($hashtag != ""){
						$hashtagArray = explode(",",$hashtag);
						if(count($hashtagArray) > 0){
							foreach($hashtagArray as $hashtagName){
								$insertHashtagArray = array("video_fk"=>$user_id,"type"=>"promovide","hashtag"=>$hashtagName,"created_at"=>date('Y-m-d H:i:s'),"created_by"=>$user_id);
								$inserthashtag = new  VideoHashtag($insertHashtagArray);
								$inserthashtag->save();
								$inserthashtag->id;
							}
						}
					}
					return response()->json(['status'=>'1','msg'=>'Promo video success uploaded.','data'=>array('id'=>$user_id)]);
				}else{
					return response()->json(['status'=>'0','msg'=>'Sorry, something went wrong. Please try again.','data'=>array()]);
				}
			}else{
				return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
			}	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Please Login','data'=>array()]);
		}
	}
	/*Like and Unlike code By Vedio Id */
	public function likeUnlikeByVedioId(){
		$user_id = Input::post('user_id');
		$hotel_id = Input::post('hotel_id');
		$vedio_id = Input::post('vedio_id');	
		$like = Input::post('like');
		$video_category = Input::post('video_category');
		if($user_id !='' && $hotel_id !='' && $vedio_id !='' && $like !='' && $video_category !=''){
			
			$checkHotelID = HotelLikeUnLike::select('id')->where('hotel_id',$hotel_id)->where('user_id',$user_id)->first();
			if(isset($checkHotelID) && $checkHotelID !=''){
					$insert = HotelLikeUnlike::where('id',$checkHotelID->id)->where('hotel_id',$hotel_id)->where('user_id',$user_id)->update(array('like'=>$like));
					$insert_id = $checkHotelID->id;
			}else{
				$data_array = array(
					'user_id'=>$user_id,
					'hotel_id'=>$hotel_id,
					'vedio_id'=>$vedio_id,
					'like'=>$like,
					'video_category'=>$video_category,
					'del_flag'=>'N',
					'created_date'=>date('Y-m-d H:i:s')
				);
				$insert = new HotelLikeUnlike($data_array);
				$insert->save();
				$insert_id = $insert->id;
			}
			if($insert_id){
				if($vedio_id !=0 && $video_category !=0){
					
					$GetLikeVideoCount = HotelVideo::select('like_count')->where('id',$vedio_id)->where('del_flag','N')->first();
					
					$GetLikeCategoryCount = HotelCategory::select('like_count')->where('category_id',$video_category)->where('hotel_id',$hotel_id)->where('del_flag','N')->first();
				
				}else{
					$GetLikeCategoryCount = Hotel::select('like_count')->where('id',$hotel_id)->where('del_flag','N')->first();
				}
				
				if($like ==1){
					$msg = 'Like';	
					if($vedio_id !=0 && $video_category !=0){
						
						$totalVideoLike = $GetLikeVideoCount->like_count +1;
						$totalCategoryLike = $GetLikeCategoryCount->like_count+1;
						$update = HotelVideo::where('id',$vedio_id)->update(array('like_count'=>$totalVideoLike));
						$update = HotelCategory::where('category_id',$video_category)->where('hotel_id',$hotel_id)->update(array('like_count'=>$totalCategoryLike));
				
					}else{
						$totalCategoryLike = $GetLikeCategoryCount->like_count+1;
						$update = Hotel::where('id',$hotel_id)->update(array('like_count'=>$totalCategoryLike));
					}
				}else{ 
					$msg = 'Unlike';
					$totalVideoLike =0;
					$totalCategoryLike =0;
					if($vedio_id !=0 && $video_category !=0){
						if($GetLikeVideoCount->like_count !=0){
							$totalVideoLike = $GetLikeVideoCount->like_count -1;
						}
						if($GetLikeCategoryCount->like_count !=0){
							$totalCategoryLike = $GetLikeCategoryCount->like_count-1;
						}
						$update = HotelVideo::where('id',$vedio_id)->update(array('like_count'=>$totalVideoLike));
						$update = HotelCategory::where('category_id',$video_category)->where('hotel_id',$hotel_id)->update(array('like_count'=>$totalCategoryLike));
				
					}else{
						if($GetLikeCategoryCount->like_count !=0){
							$totalCategoryLike = $GetLikeCategoryCount->like_count-1;
						}
						$update = Hotel::where('id',$hotel_id)->update(array('like_count'=>$totalCategoryLike));
					}
				}
				
				$insert = new HotelView(array('user_id'=>$user_id,'hotel_id'=>$hotel_id,'category_id'=>$video_category,'video_id'=>$vedio_id,'like'=>$like));
				$insert->save();
				return response()->json(['status'=>'1','msg'=>$msg.' success added.','data'=>array(array('id'=>$insert_id,'like'=>$like))]);	
			}
			else{
				return response()->json(['status'=>'0','msg'=>'Sorry, something went wrong. Please try again.','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
		
	}
	
	/*end code Like and Unlike */

	/*Start category wise Hotel Video*/
	public function categoryWiseHotelVideo(){
		$hotel_id = Input::get('hotel_id');
		$category_id = Input::get('category_id');
		if($hotel_id !='' && $category_id !=''){
			$GetVideoList = HotelVideo::AllDetailsByHotelId($hotel_id,$category_id);
			if(count($GetVideoList) >0){
				return response()->json(['status'=>'1','msg'=>'Success.','data'=>$GetVideoList->toArray()]);
			}else{
				return response()->json(['status'=>'0','msg'=>'No record available','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
		
	}

  	/*End category wise Hotel Video */
	
	/********** hotel social Login *************/
	public function hotel_social_login(Request $request) {
		$social_id = Input::post('social_id');
        $social_type = Input::post('social_type');
        $first_name = Input::post('first_name');
        $last_name = Input::post('last_name');
        $email = Input::post('email');
        $password = Input::post('password');
       if ($social_id != '' && $social_type !='' && $first_name !='' )  {
		     $number = Hotel::where(array("social_id" => $social_id, "social_type" => $social_type, "del_flag" => 'N', "active" => '1'))->count();
	//	   date_default_timezone_set("UTC");
            $time1 = date("Y-m-d h:i:s");
		   	if($number ==0){
				
				 $data = array(
                    "full_name" => $first_name.' '.$last_name,
                   
                    "social_id" => $social_id,
                    "social_type" => $social_type,
                    "created_date" => $time1,
                    "active" => 1,
                    "email" => $email
                );
				
			
                    $insertsid  = new Hotel($data);
					$insertsid->save();
					$insert  =$insertsid->id;
					$datas = Hotel::where('id',$insert)->where('active',1)->where('del_flag','N')->first();
					return response()->json(['status' => "1", 'msg' => "success", 'data' => array($datas)]);
			}else{
				$row = Hotel::where(array("social_id" => $social_id, "social_type" => $social_type))->first();
				
				 $data = array(
                    "full_name" => $first_name.' '.$last_name,
                    "active" => 1
                );
                if ($email != '') {
                    $data['email'] = $email;
                }
				Hotel::where(array('id' => $row->id))->update($data);
				
				$data = Hotel::where('id',$row->id)->where('active',1)->where('del_flag','N')->first();
				return response()->json(['status' => "1", 'msg' => "success", 'data' => array($data)]);
			}
		   
	   }else{
		   return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
	   }
		
	}
	
	/***********************end Hotel Social Login ******************************************/
	/* Start multiple hotel video  delete */
	public function deleteMulitpleVideoByHotelId(){
		$user_id= Input::get('user_id');
		$videoId = Input::get('video_id');
		
		if($user_id !='' && $videoId !=''){
			$video_id  = explode(',',$videoId);
			foreach($video_id as $val){
				$update = HotelVideo::where('hotel_id',$user_id)->where('id',$val)->update(array('del_flag'=>'Y','deleted_date'=>date('Y-m-d h:i:s'),'deleted_by'=>$user_id));
			}
			if($update){
				$return_response = array(
					'user_id'=>$user_id
				);
				return response()->json(['status' => "1", 'msg' => "Hotel video successfully deleted", 'data' =>array($return_response)]);
			}		
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	/*End multiple hotel video delete*/
	
	/*Hotel Dashboard */
	public function hotelDashboard(){  
		$user_id = Input::get('user_id');
		if($user_id !=''){
			$getCategoryName = Category::select('id','category_name')->where('del_flag','N')->get();
			$final_Array = array();
			
			/* Start Most popular view video by hotel Id */
			$VideoDetails = HotelVideo::select('id','view_count','url')->where('hotel_id',$user_id)->orderBy('view_count','desc')->first();
			$VideoArray = array();
			if($VideoDetails!=''){
				$VideoArray = array($VideoDetails);
			}
			/* End Most popular view video by hotel Id */
			
			$viewVountHotel = Hotel::select('view_count')->where('id',$user_id)->first();
			
			if(count($getCategoryName)>0){
				foreach($getCategoryName as $val){
					$query = HotelCategory::select('view_count','like_count')->where('hotel_id',$user_id)->where('category_id',$val->id)->where('del_flag','N')->first();
					$viewCount = 0;
					$likeCount = 0;
					if( $query !=null){
						$viewCount = $query->view_count;
					}
					if($query!=null){
						$likeCount = $query->like_count;
					}
					$val->view_count = $viewCount;
					$val->like_count = $likeCount;
				}
				$final_Array =array(
					'viewHotel'=>$viewVountHotel->view_count,
					'ViewMaxmimVideo'=>$VideoArray,
					'CategoryWise'=>$getCategoryName
				
				);
				return response()->json(['status' => "1", 'msg' => "Success", 'data' =>array($final_Array)]);
			}else{
				return response()->json(['status' => "0", 'msg' => "No record available", 'data' =>array()]);	
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
		
	}
	
	/*end hotel dashboard */
	
	/**************Start category wise video view and like ******************/
	public function categoryWiseVideoLikeView(){
		$user_id = Input::get('user_id');
		$category_id = Input::get('category_id');
		
		if($user_id !='' && $category_id !=''){
			$query = HotelVideo::select('id','url','view_count','like_count','hashtag')->where('hotel_id',$user_id)->where('category_fk',$category_id)->get();
			if($query !=''){
				
					return response()->json(['status' => "1", 'msg' => "Success", 'data' =>$query->toArray()]);
			}else{
				return response()->json(['status' => "0", 'msg' => "No record available", 'data' =>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
		
		
	}
	/**************End category wise video view and like ******************/
	/**************Start Country List ******************/
	public function countryList(){
		$query = Country::where('del_flag','N')->get();
		return response()->json(['status' => "1", 'msg' => "Success", 'data' =>$query]);
	}
	/**************End Country List ******************/
	/**************Start Country List ******************/
	public function rankOfHotel(){
		$query= array(array("hotelRank"=>'10',"TotalHotel"=>"50"));
		return response()->json(['status' => "1", 'msg' => "Success", 'data' =>$query]);
	}
	/**************End Country List ******************/
	/**************Start Hotel video List ******************/
	public function totalHotelVideo(){
		$start_date = Input::get('end_date');
		$end_date = Input::get('start_date');
		$hotel_id = Input::get('hotel_id');
		if($start_date !='' && $end_date !=''){
			$query = HotelView::selectRaw('count(id) as totalofdate,date(created_date) as date')
			->where('hotel_id',$hotel_id)
			->whereNotNull('video_id')
			->whereRaw('created_date >= "'.$start_date.'" and created_date <= "'.$end_date.'"')
			->groupBy(DB::raw('date(created_date)'))
			->get();
			
			$counlist= array();
			$counterView = 0;
			foreach($query as $list){
				$counlist[$list->date] = $list->totalofdate;
				$counterView = $counterView+ $list->totalofdate;
			}
			$finalArray = array();
			for($i = strtotime($start_date);$i <= strtotime($end_date); $i = strtotime($selectdate)){
				$selectdate = date('Y-m-d',$i);
				if(isset($counlist[$selectdate])){
					$finalArray[$selectdate] = "$counlist[$selectdate]";
				}else{
					$finalArray[$selectdate] = '0';
				}
				$selectdate = date('Y-m-d', strtotime($selectdate . ' +1 day'));
			}
			//echo "<pre>"; print_r($finalArray); die();
			return response()->json(['status' => "1", 'msg' => "Success", 'data' =>array('counterView'=>"$counterView",'counterList'=>$finalArray)]);	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	/**************End Hotel video List ******************/
	/**************Start Hotel follower List ******************/
	public function totalHotelFollowers(){
		$start_date = Input::get('end_date');
		$end_date = Input::get('start_date');
		$hotel_id = Input::get('hotel_id');
		if($start_date !='' && $end_date !=''){
			$counlist= array();
			$counterView = 0;
			$query = FollowUnfollow::selectRaw('count(id) as totalofdate,date(created_date) as date')
			->where('hotel_id',$hotel_id)
			->where('follow_unfollow','follow')
			->where('del_flag','N')
			->whereRaw('date(created_date) >= "'.$start_date.'" and date(created_date) <= "'.$end_date.'"')
			->groupBy(DB::raw('date(created_date)'))
			->get();
			
			
			foreach($query as $list){
				$counlist[$list->date] = $list->totalofdate;
				$counterView = $counterView+ $list->totalofdate;
			}
			$finalArray = array();
			for($i = strtotime($start_date);$i <= strtotime($end_date); $i = strtotime($selectdate)){
				$selectdate = date('Y-m-d',$i);
				if(isset($counlist[$selectdate])){
					$finalArray[$selectdate] = "$counlist[$selectdate]";
				}else{
					$no= 0;
					$finalArray[$selectdate] = "$no";
				}
				$selectdate = date('Y-m-d', strtotime($selectdate . ' +1 day'));
			}
			return response()->json(['status' => "1", 'msg' => "Success", 'data' =>array('counterView'=>"$counterView",'counterList'=>$finalArray)]);	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	/**************End Hotel follower List ******************/
	/**************Start Hotel profile List ******************/
	public function totalHotelProfile(){
		$start_date = Input::get('end_date');
		$end_date = Input::get('start_date');
		$hotel_id = Input::get('hotel_id');
		if($start_date !='' && $end_date !=''){
			$query = HotelView::selectRaw('count(id) as totalofdate,date(created_date) as date')
			->where('hotel_id',$hotel_id)
			->whereNull('video_id')
			->whereRaw('created_date >= "'.$start_date.'" and created_date <= "'.$end_date.'"')
			->groupBy(DB::raw('date(created_date)'))
			->get();
			
			$counlist= array();
			$counterView = 0;
			foreach($query as $list){
				$counlist[$list->date] = $list->totalofdate;
				$counterView = $counterView+ $list->totalofdate;
			}
			$finalArray = array();
			for($i = strtotime($start_date);$i <= strtotime($end_date); $i = strtotime($selectdate)){
				$selectdate = date('Y-m-d',$i);
				if(isset($counlist[$selectdate])){
					$finalArray[$selectdate] = "$counlist[$selectdate]";
				}else{
					$finalArray[$selectdate] = '0';
				}
				$selectdate = date('Y-m-d', strtotime($selectdate . ' +1 day'));
			}
			//echo "<pre>"; print_r($finalArray); die();
			return response()->json(['status' => "1", 'msg' => "Success", 'data' =>array('counterView'=>"$counterView",'counterList'=>$finalArray)]);	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	/**************End Hotel profile List ******************/
	///Hotel Video analytic detail
	public function hotelVideoanlytic(){
		$hotel_id = Input::get('hotel_id');
		if($hotel_id !=''){
			$sixTrendingVideo = HotelVideo::getSixTrendingVideo($hotel_id);
			$sixRecentVideo = HotelVideo::getSixRecentVideo($hotel_id);
			
			return response()->json(['status' => "1", 'msg' => "Success", 'data' =>array('sixTrendingVideo'=>$sixTrendingVideo,'sixRecentVideo'=>$sixRecentVideo)]);	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	///END Hotel Video analytic detail
	///Hotel hotel Follow UnFollow
	public function hotelFollowUnFollow(){
		$hotel_id = Input::get('hotel_id');
		$user_id = Input::get('user_id');
		$follow_unfollow = Input::get('follow_unfollow');
		if($hotel_id !='' && $user_id !='' && $follow_unfollow !=''){
			$checkFolooeUnfollow = FollowUnfollow::where('hotel_id',$hotel_id)->where('user_id',$user_id)->where('del_flag','N')->first();
			if($checkFolooeUnfollow){
				$active =FollowUnfollow::where(array("id" => $checkFolooeUnfollow->id))->update(array('follow_unfollow'=>$follow_unfollow,'created_date'=>date('Y-m-d H:i:s')));
			}else{
				$insertData = array('hotel_id'=>$hotel_id,'user_id'=>$user_id,'follow_unfollow'=>$follow_unfollow,'created_date'=>date('Y-m-d H:i:s'));
				$insert = new FollowUnfollow($insertData);
				$insert->save();
			}
			return response()->json(['status' => "1", 'msg' => "Success", 'data' =>""]);	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	///END hotel Follow UnFollow
	///Hotel hotel Follow UnFollow analytic for male female and country
	public function hotelFollowUnFollowBycountry(){
		$hotel_id = Input::get('hotel_id');
		if($hotel_id !=''){
			$query = FollowUnfollow::select('*')
			->where('hotel_id',$hotel_id)
			->where('follow_unfollow','follow')
			->where('del_flag','N')
			->get();
			$countryList = Country::where('del_flag','N')->get();
			$countryArray = array();
			foreach($countryList as $country){
				$countryTempArray = array('id'=>$country->id,'country_name'=>$country->country_name,'counter'=>0);
				$countryArray[$country->id] = $countryTempArray;
			}
			$userList = Customer::where('del_flag','N')->where('active','1')->where('active','1')->whereNotNull('gander')->get();
			$userArray = array('male'=>0,'female'=>0);
			$userArrayMaleFemale = array();
			$userArraycountry = array();
			foreach($userList as $user){
				$userArrayMaleFemale[$user->id] = $user->gander;
				$userArraycountry[$user->id] = $user->country;
			}
			
			foreach($query as $follow){
				if(isset($userArraycountry[$follow->user_id])){
				$countryArray[$userArraycountry[$follow->user_id]]['counter']++;
				if($userArrayMaleFemale[$follow->user_id] == 'male'){
					$userArray['male']++;
				}
				if($userArrayMaleFemale[$follow->user_id] == 'female'){
					$userArray['female']++;
				}
				}
			}
			
			return response()->json(['status' => "1", 'msg' => "Success", 'data' =>array('totalCount'=>count($query),'userArrayMaleFemale'=>$userArray,'countryArray'=>$countryArray)]);	
		}else{
			return response()->json(["status"=>"0",'msg' => 'Parameter required','data'=>array()]);
		}
	}
	///END Hotel Video analytic detail
	
	
	/* Perticular hotel details */
	
	public function hotelDetailsPer(){
		$user_id = Input::get('user_id');
		
		if($user_id !='' ){
			$final_array = array();
			$query = Hotel::viewHotelById($user_id);
			$query->book_now = $query->book_now;
			//$total_view = $query->view_count+1;
			//$update  = Hotel::where('id',$hotel_id)->update(array('view_count'=>$total_view));
			//$insert = new HotelView(array('hotel_id'=>$hotel_id,'user_id'=>$user_id));
					//$insert->save();
			
			if($query !=''){
				//$query->view_count = $total_view;
				$HotelImages = WebService::hotelProfileImageByHotelId($user_id);
				$query->hotelProfile =$HotelImages;
				$getCategory = DB::table('ht_category_master')->select('id','category_name')->where('del_flag','N')->get();
				if(isset($getCategory) && $getCategory !=''){
					foreach($getCategory as $vals){
						$getVideoByCategory = HotelVideo::userSideHotelVideo($user_id,$vals->id);
						$vals->Video = $getVideoByCategory;
					}
				}
				$query->HotelVideo =$getCategory; 
				$checkFollowUnfollow = FollowUnfollow::where('hotel_id',$user_id)->where('follow_unfollow','follow')->where('del_flag','N')->first();
				$query->follow =""; 
				if($checkFollowUnfollow){
					$query->follow ="Yes"; 
				}
				
				
				$final_array[] = $query;
				
				return response()->json(["status"=>'1','message' => 'Success','data'=>$final_array],$this-> successStatus);
			}else{
				return response()->json(["status"=>"0",'message' => 'No record available','data'=>array()]);
			}
		}else{
			return response()->json(["status"=>"0",'message' => 'Parameter Required','data'=>array()]);
		}
	}
	
	/*end Perticular hotel details */

	public function Slider(){
		$query = Slider::GetSliderImages();
		if(!empty($query)){
			foreach($query as $val){
				$slider_img = '';
				if($val->slider_img !=''){
					$slider_img = URL::to('/').'/public/upload/image/'.$val->slider_img;
				}
				$val->slider_img = $slider_img ;
				$login_img ='';
				if($val->login_img !=''){
					$login_img = URL::to('/').'/public/upload/image/'.$val->login_img;
				}
				$val->login_img =$login_img;
			}
		}
		return response()->json(["status"=>'1','message' => 'Success','data'=>$query->toArray()],$this-> successStatus);
	}
}