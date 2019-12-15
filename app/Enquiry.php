<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use SoftDeletes;
    protected $table = 'enquiry';

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at', 'updated_by'
    ];

    public function followUps(){
        return $this->hasMany('App\FollowUp');
    }

}
