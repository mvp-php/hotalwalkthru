<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Country extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_country_master';
    protected $fillable = ['id', 'country_name', 'del_flag'];
    
}