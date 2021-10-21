<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Slider extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_slider_master';
    protected $fillable = ['id', 'name', 'description','slider_img','login_img','created_date','created_by','updated_date','updated_by','del_flag'];

	public static function GetSliderImages(){
		$query = Slider::select('id','name','description','slider_img','login_img')->where('del_flag','N')->get();
		return $query;
	}
}