<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class VideoHashtag extends Authenticatable {
    use Notifiable;

    public $timestamps = false;
    protected $table = 'ht_video_hashtag';
    protected $fillable = ['id', 'video_fk', 'type','hashtag', 'created_at', 'created_by', 'status'];
}