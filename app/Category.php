<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Category extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_category_master';
    protected $fillable = ['id', 'category_name', 'del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','view_count','like_count'];
    
    public static function editCategoryById($id){
        $query = Category::where("del_flag",'N')->where('id',$id)->first();
        return $query;
    }

    public static function categoryList(){
        $query = Category::where("del_flag",'N')->orderBy('category_name','asc')->get();
        return $query;
    } 
    
}