<?php


namespace App\Services;

use App\Enquiry;
use Illuminate\Support\Facades\DB;

class EnquiryService
{

    public function store($validatedData, $user_id) {
        $validatedData['created_by'] = $user_id;
        $enquiry = Enquiry::create(
            $validatedData
        );
        return $enquiry;
    }

    /**
     * Returns the list of enquiries for datatables.net
     * @return mixed : List of enquiries.
     */
    public function getDatatable()
    {
        return Enquiry::orderBy('created_at', 'desc');
    }

    public function delete($id) {
        return Enquiry::where('id', $id)
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
