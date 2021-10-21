<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Auth;
use Hash;
use App\User;
class AdminProfileController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		
		
    }

    /**
     * Show the application edit profile page .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
		$data['Session']=Auth::user();
		/* Edit record by session Id*/
		$data['profileEdit'] =User::profileEditById($data['Session']->id);
		/*end Edit record by session Id*/
	   return view('admin/profile/profile',$data);
    }
	

	/**
     * Update Profile page by id .
     *
     */
	 
	public function updateProfileById(Request $request){
		$data['Session']=Auth::user();
		$customMessages = [
                'first_name.required' => 'Please enter first name.',
                'last_name.required' => 'Please enter last name.',
               'email.required' => 'Please enter email address.',
                'mobile.required' => 'Please enter mobile number.'
            ];
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
                'file_img'=>'mimes:jpeg,jpg,png,gif'
            ];
			$validator = Validator::make($request->all(), $rules, $customMessages);
			if ($validator->fails()) {
                return redirect("profile")->withErrors($validator, 'login')->withInput();
            }else {
                if($request->file('file_img') !=''){
                    $image = $request->file('file_img');
                    $photo = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/upload/');
                    $image->move($destinationPath, $photo);
                }else{
                    $photo = Input::post('old_img');
                }
				$update_array = array(
                    'first_name' => Input::post('first_name'),
                    'last_name' => Input::post('last_name'),
                    'email' => Input::post('email'),
                    'mobile' => Input::post('mobile'),
                    'address' => Input::post('address'),
                    'profileImg' => $photo
                );
                $update = User::where('id',Input::post('id'))->update($update_array);
				Session::flash('success','Profile successfully updated');
                return redirect('profile');
                
			}
	}
		
	
	/**
     * Change password function .
     *
     */
	
	public function changePasswrod(Request $request){
		$data['Session']=Auth::user();

        $data['password_changed'] =User::profileEditById($data['Session']->id);
		return view('admin/changePassword/changePassword',$data);
	}
	
	/** check validation of old password match or not*/
	
	public function CheckOldPasswordById(Request $request){
		
		$password = Input::post('old_password');
        $id = Input::post('id');
		$query = User::CheckOldPasswordById($id);
        
		if(Hash::check($password, $query->password)){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/**
	* Update password by id 
	*/
	public function updatePassword(Request $request){
			$data['Session']=Auth::user();
           $customMessages = [
                'old_password.required' => 'Please enter old password.',
                'new_password.required' => 'Please enter new password',
               'confirm_password.required' => 'Please enter confirm password.',
            ];
            $rules = [
                'old_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("changePassword")->withErrors($validator, 'login')->withInput();

            } else {
                if(Input::post('new_password') == Input::post('confirm_password')){
                    $update_array = array(
                        'password' => bcrypt(Input::post('new_password'))
                    );
                    $update = User::where('id',$data['Session']->id)->update($update_array);

                    if($update){
                        Session::flash('success','Password successfully updated.');
                        return redirect('changePassword');
                    }else{
                        Session::flash('error','Sorry, something went wrong. Please try again..');
                        return redirect('changePassword');
                    }
              }
            }

        }
		
		/**Logout function **/
		
		public function logout(){
			Auth::logout();
			Session::flush('success','Logout successfully.');
			return redirect('/login');
		}
	
}
