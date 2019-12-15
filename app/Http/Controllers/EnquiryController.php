<?php

namespace App\Http\Controllers;

use App\Enquiry;
use App\Services\EnquiryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class EnquiryController extends Controller
{
    protected $enquiryService;

    public function __construct(EnquiryService $enquiryService)
    {
        $this->enquiryService = $enquiryService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('enquiry.manage-enquiry');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('enquiry.add-enquiry');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'student_name' => 'required',
            'student_address' => 'required',
            'student_number' => 'required|digits:10',
            'student_college' => 'required',
            'student_year' => 'required|numeric',
            'student_branch' => 'required',
            'comments' => 'required'
        ]);

        try {
            $this->enquiryService->store($validatedData, Auth::user()->id);

            return redirect('/enquiry')->with([
                'type' => 'success',
                'title' => 'Enquiry added successfully',
                'message' => 'The given Enquiry has been added successfully'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed to add the Enquiry',
                'message' => "There was some issue in adding the Enquiry"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            $enquiry = Enquiry::findOrFail($id);
            return view('enquiry.view-enquiry')->with(
                [
                    'enquiry' => $enquiry
                ]
            );
        } catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed To show Enquiry',
                'message' => 'Error in viewing Enquiry'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->ipr;
        $ipr = Enquiry::find($id);
        return view('enquiry.edit-enquiry')->with('enquiry', $ipr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'year' => ['required', 'date'],
            'patents_published_count' => ['required', 'numeric'],
            'patents_granted_count' => ['required', 'numeric'],
            'additional_columns' => ''
        ]);

        $updateSuccessful = $this->iprService->update($validatedData, $id, Auth::id());

        if($updateSuccessful) {
            return redirect('/enquiry')->with([
                'type' => 'success',
                'title' => 'Enquiry updated successfully',
                'message' => 'The given Enquiry has been updated successfully'
            ]);
        }

        return redirect()->back()->with([
            'type' => 'danger',
            'title' => 'Failed to update the Enquiry',
            'message' => "There was some issue in updating the Enquiry"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->enquiryService->delete($id);
            return redirect()->back()->with([
                'type' => 'success',
                'title' => 'Enquiry Deleted successfully',
                'message' => 'The given Enquiry has been deleted successfully'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed To Delete Enquiry',
                'message' => 'Error in deleting Enquiry'
            ]);
        }
    }

    public function getEnquiry() {
        /*CURRENT USER PUBLISHED BOOKS*/
        $enquiry = $this->enquiryService->getDatatable();

        return DataTables::of($enquiry)
            ->addColumn('edit', function(Enquiry $enquiry) {
                return '<button data-enquiryid="'.$enquiry->id.'" class="edit fa fa-pencil-alt btn-sm btn-warning" data-toggle="modal" data-target="#editModal"></button>';
            })
            ->addColumn('delete', function(Enquiry $enquiry) {
                return '<button data-enquiryid="'.$enquiry->id.'" class="delete fa fa-trash btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('view', function(Enquiry $enquiry) {
                return '<a href="/enquiry/'.$enquiry->id.'" class="fa fa-search btn-sm btn-success"></a>';
            })
            ->rawColumns(['edit', 'delete', 'view'])
            ->make(true);
    }
}
