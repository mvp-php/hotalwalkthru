<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use Auth;
use App\Hotel;

class AdminHotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$data['Session'] = Auth::user();
		return view("admin.hotel.index",$data);
		
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
		$data['Session'] = Auth::user();
		$data['id'] = $id = Input::get('id');
		/* Start Display data specified id*/
		$data['hotel_view'] = Hotel::viewHotelById($id);
		
		/* End Display data specified id */
		return view("admin.hotel.hotel_view",$data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
		$data['Session'] = Auth::user();
		$data['id'] = $id = Input::get('id');
		$update = Hotel::where('id', $id)->update(array('del_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $data['Session']->id));
		if ($update) {
			Session::flash('success', "Hotel successfully deleted.");
			return redirect('hotel');
		} else {
			Session::flash('error', 'Sorry, something went wrong. Please try again.');
			return redirect('hotel');
		}

    }
	/** get data using datatable ajax**/
	public function ajax_list() {
		$data['Session'] = Auth::user();
		$category = Hotel::HotelList();
		$n =1;
		foreach($category as $c){
			$c->No = $n;
			$n++;
		}

		return Datatables::of($category)
			->addColumn('Action', function ($category) {
				$conf = "'Are you sure to delete the detail permanently?'";
				$action = '<a href="hotel-view?id='.$category->id.'"><i class="icon feather icon-eye f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$category->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>';
				return $action;
			})
			->addColumn('status', function ($category) {
				if($category->active ==1){
					$msg = "'Are you sure to account deactive  permanently?'";
					$status ='<a href="javascript:void(0);" onclick="AccountActiveOrDeactive('.$category->id.',0);"><label class="label label-danger">Deactive</label></a>';
				}else{
					$msg = "'Are you sure to account active  permanently?'";
					$status ='<a href="javascript:void(0);" onclick="AccountActiveOrDeactive('.$category->id.',1);"><label class="label label-success">Active</label></a>';
				}
				return $status;
			})
			->rawColumns(['Action','status'])
			->make(true);
    }
	
	/**
     * Active and deactive the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ActiveOrDeactive()
    {
		$data['Session'] = Auth::user();
		$data['id'] = $id = Input::get('id');
		$status = Input::get('status');
		$update = Hotel::where('id', $id)->update(array('active' => $status));
		if ($update) {
			if($status==1){
				$msg = 'deactive';
			}else{
				$msg = 'active';
			}
			Session::flash('success', "Account successfully ".$msg.".");
			return redirect('hotel');
		} else {
			Session::flash('error', 'Sorry, something went wrong. Please try again.');
			return redirect('hotel');
		}
    }
}