<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $table = 'ht_admin_master';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	/**Profile edit data by id*/
	public static function profileEditById($id){
		$query = User::where('id',$id)->first();
		return $query;		
	}
	
	
	/**Check validtion of old password match or not*/
	public static function CheckOldPasswordById($id){
		$query = User::select('password')->where('id',$id)->first();
		return $query;		
	}
	
	
	
}
