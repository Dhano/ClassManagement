<?php


namespace App\Services;

use App\Enquiry;
use App\FollowUp;
use Illuminate\Support\Facades\DB;

class FollowUpService
{

    public function store($validatedData, $enquiry_id, $user_id) {
        $validatedData['created_by'] = $user_id;
        $validatedData['enquiry_id'] = $enquiry_id;
        $followup = FollowUp::create(
            $validatedData
        );
        return $followup;
    }

    /**
     * Returns the list of states for datatables.net
     * @return mixed : List of States.
     */
    public function getDatatable($enquiry_id)
    {
        return FollowUp::orderBy('created_at', 'desc')
            ->where('enquiry_id',$enquiry_id);
    }

    public function delete($id) {
        return FollowUp::where('id', $id)
            ->delete();
    }

    public function update($validatedData, $id, $user_id) {
        try {
            DB::beginTransaction();
                $ipr = Enquiry::find($id);
                $ipr->year = $validatedData['year'];
                $ipr->patents_published_count = $validatedData['patents_published_count'];
                $ipr->patents_granted_count = $validatedData['patents_granted_count'];
                $ipr->additional_columns = $validatedData['additional_columns'];
                $ipr->updated_by = $user_id;
                $ipr->save();
            DB::commit();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
