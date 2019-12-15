<?php
/**
 * Created by PhpStorm.
 * User: Dhananjay
 * Date: 6/25/2019
 * Time: 12:47 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUp extends Model
{
    use SoftDeletes;

    protected $table = 'follow_ups';

    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at', 'updated_by'
    ];

    public function enquiry() {
        return $this->belongsTo('App\Enquiry');
    }
}
