<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use Auth;
use App\Subscription;

class AdminSubscriptionController extends Controller
{
	function __construct(){
		$this->middleware('auth');
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data['Session'] = Auth::user();
		return view("admin.subscription.subscription_list",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$data['Session'] = Auth::user();
		return view('admin.subscription.subscription_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		
		$data['Session'] = Auth::user();
        $customMessages = [
                'plan_name.required' => 'The Plan name field is required.',
				'price.required' => 'The Plan price field is required.',
				'duration.required' => 'The Plan duration field is required.',
            ];
            $rules = [
                'plan_name' => 'required',
				'description' => 'required',
				'price' => 'required',
				'duration' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
			if ($validator->fails()) {
                return redirect("/subscriptionAdd")
                                ->withErrors($validator, 'subscription')
                                ->withInput();
            } else {
                 
                 $data_array = array(
                    'plan_name' => Input::post('plan_name'),
					'plan_description'=>Input::post('description'),
					'price'=>Input::post('price'),
					'duration'=>Input::post('duration'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $data['Session']->id
                );
                $insert = new Subscription($data_array);
                $insert->save();
                $update = $insert->id;
                if ($update) {
                    Session::flash('success', "Subscription successfully inserted.");
                    return redirect('subscription');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('subscriptionAdd');
                }
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
		$data['Session'] = Auth::user();
		$data['id'] = $id = Input::get('id');
		$data['subscription'] = Subscription::select('plan_name','plan_description','price','duration')->where('id',$id)->first();
		return view('admin.subscription.subscription_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
		
		$data['Session'] = Auth::user();
		$id = Input::post('id');
        $customMessages = [
                'plan_name.required' => 'The Plan name field is required.',
				'price.required' => 'The Plan price field is required.',
				'duration.required' => 'The Plan duration field is required.',
            ];
            $rules = [
                'plan_name' => 'required',
				'description' => 'required',
				'price' => 'required',
				'duration' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
			if ($validator->fails()) {
                return redirect("/subscriptionEdit?id=".$id)
                                ->withErrors($validator, 'subscription')
                                ->withInput();
            } else {
                 
                 $data_array = array(
                    'plan_name' => Input::post('plan_name'),
					'plan_description'=>Input::post('description'),
					'price'=>Input::post('price'),
					'duration'=>Input::post('duration'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $data['Session']->id
                );
                $insert =Subscription::where('id',$id)->update($data_array);
               
                if ($insert) {
                    Session::flash('success', "Subscription successfully updated.");
                    return redirect('subscription');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('subscriptionEdit?id='.$id);
                }
            }
			
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
		$data['Session'] = Auth::user();
		$data['ids'] = $id = Input::get('id');
		$update = Subscription::where('id', $id)->update(array('del_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $data['Session']->id));
		if ($update) {
			Session::flash('success', "Subscription successfully deleted.");
			return redirect('subscription');
		} else {
			Session::flash('error', 'Sorry, something went wrong. Please try again.');
			return redirect('subscription');
		}
    }
	
	/** get data using datatable ajax**/
	public function ajax_list() {
		$data['Session'] = Auth::user();
		$category = Subscription::subscriptionList();
		$n =1;
		foreach($category as $c){
			$c->No = $n;
			$n++;
		}
		return Datatables::of($category)
			->addColumn('Action', function ($category) {
				$conf = "'Are you sure to delete the detail permanently?'";
				$action = '<a href="subscriptionEdit?id='.$category->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$category->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>';
				return $action;
			})

			->rawColumns(['Action'])
			->make(true);
    }
}
