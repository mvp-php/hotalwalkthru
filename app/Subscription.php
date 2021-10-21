<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	 use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_subscription_master';
    protected $fillable = ['id', 'plan_name', 'plan_description','price','duration','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date'];
    
    public static function subscriptionList(){
		$query = Subscription::select('ht_subscription_master.id','ht_subscription_master.plan_name','ht_subscription_master.price','ht_subscription_master.duration')->where('del_flag','N')->orderBy('id','desc')->get();
		return $query;
	}
}
