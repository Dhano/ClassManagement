<?php
/**
 * Created by PhpStorm.
 * User: Dhananjay
 * Date: 6/25/2019
 * Time: 12:48 AM
 */

namespace App\Services;


use App\FollowUp;

class ClassService
{

    public function store($validatedData, $user_id){

        $class=FollowUp::create([
            'year' => $validatedData['year'],
            'created_by' => $user_id
        ]);

        return $class;

    }

    /**
     * Returns the list of states for datatables.net
     * @return mixed : List of States.
     */
    public function getDatatable()
    {
        return FollowUp::orderBy('created_at', 'desc');
    }

    public function getClassStudentsDatatable($class){
            error_log('returning class students');
        error_log($class->students);
            return $class->students;
    }

    public function delete($id,$user_id){
        return FollowUp::where('id', $id)
            ->delete();
    }
}
