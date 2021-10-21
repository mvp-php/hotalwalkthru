<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
   
   use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_email_template';
    protected $fillable = ['id', 'title', 'subject','mail','del_flag','created_by', 'created_date'];
    
    public static function GetEmailTemplate($id){
        $query = EmailTemplate::where("del_flag",'N')->where('id',$id)->first();
        return $query;
    }

    
	
}
