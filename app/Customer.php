<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_user_master';
    protected $fillable = ['id','full_name','email','password','mobile','profile_img','del_flag','created_by', 'created_date', 'updated_by', 'updated_date', 'deleted_by', 'deleted_date','active','otp','key','social_id','social_type','type','country','gander'];
    
	
}
