<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\Datatables\Datatables;
use Auth;
use App\Category;
class AdminCategoryController extends Controller
{
	function __construct(){
		$this->middleware('auth');
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
		return view('admin.category.category_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$data['Session'] = Auth::user();
        $customMessages = [
                'category_name.required' => 'The Category field is required.',
            ];
            $rules = [
                'category_name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
			if ($validator->fails()) {
                return redirect("/category-add")
                                ->withErrors($validator, 'Category')
                                ->withInput();
            } else {
                 
                 $data_array = array(
                    'category_name' => Input::post('category_name'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $data['Session']->id
                );
                $insert = new Category($data_array);
                $insert->save();
                $update = $insert->id;
                if ($update) {
                    Session::flash('success', "Category successfully inserted.");
                    return redirect('category');
                } else {
                    Session::flash('error', 'Sorry, something went wrong. Please try again.');
                    return redirect('category-add');
                }
            }
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data['Session'] = Auth::user();
		return view("admin.category.category_list",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data['Session'] = Auth::user();
		$data['ids'] = $id = Input::get('id');
		
		/*editing data the specified id*/
        
		$data['category_data'] = Category::editCategoryById($id);
		
		/*End*/
		return view("admin.category.category_edit",$data);
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
		$data['Session'] = Auth::user();
		$customMessages = [
                'category_name.required' => 'The Category field is required.',
            ];
            $rules = [
                'category_name' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect("category-edit?id=" . Input::post('id'))
                                ->withErrors($validator, 'Category')
                                ->withInput();
            } else {
                $data_array = array(
                    'category_name' => Input::post('category_name'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $data['Session']->id
                );
                
                $update = Category::where('id', Input::post('id'))->update($data_array);
                Session::flash('success', 'Category updated successfully.');
                return redirect('/category');
            }
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
		$data['ids'] = $id = Input::get('id');
		$update = Category::where('id', $id)->update(array('del_flag' => 'Y', 'deleted_date' => date('Y-m-d H:i:s'), 'deleted_by' => $data['Session']->id));
		if ($update) {
			Session::flash('success', "Category successfully deleted.");
			return redirect('category');
		} else {
			Session::flash('error', 'Sorry, something went wrong. Please try again.');
			return redirect('category');
		}
    }
	
	/** get data using datatable ajax**/
	public function ajax_list() {
		$data['Session'] = Auth::user();
		$category = Category::categoryList();
		$n =1;
		foreach($category as $c){
			$c->No = $n;
			$n++;
		}
		return Datatables::of($category)
			->addColumn('Action', function ($category) {
				$conf = "'Are you sure to delete the detail permanently?'";
				$action = '<a href="category-edit?id='.$category->id.'"><i class="icon feather icon-edit f-w-600 f-16 m-r-15 text-c-green"></i></a><a href="javascript:void(0);" onclick="deleteswal('.$category->id.');"><i class="feather icon-trash-2 f-w-600 f-16 text-c-red"></i></a>';
				return $action;
			})

			->rawColumns(['Action'])
			->make(true);
    }
}