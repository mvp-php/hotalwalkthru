<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class FollowUnfollow extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_follow_unfollow';
    protected $fillable = ['id','hotel_id','user_id','follow_unfollow','del_flag','created_date'];
  
}
