<?php

namespace App\Http\Controllers;

use App\Enquiry;
use App\Services\EnquiryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class IPRController extends Controller
{
    protected $iprService;

    public function __construct(EnquiryService $iprService)
    {
        $this->iprService = $iprService;
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
            'year' => ['required', 'date'],
            'patents_published_count' => ['required', 'numeric'],
            'patents_granted_count' => ['required', 'numeric'],
            'additional_columns' => ''
        ]);

        try {
            $this->iprService->store($validatedData, Auth::user()->staff->id);
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
            $this->iprService->delete($id,Auth::id());
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

    public function getIPR() {
        /*CURRENT USER PUBLISHED BOOKS*/
        $ipr = $this->iprService->getDatatable(Auth::id());

        return DataTables::of($ipr)
            ->addColumn('edit', function(Enquiry $ipr) {
//                Redirect to page
                return '<button id="'.$ipr->id.'" class="edit fa fa-pencil-alt btn-sm btn-warning" data-toggle="modal" data-target="#editModal"></button>';
            })
            ->addColumn('delete', function(Enquiry $ipr) {
                return '<button id="'.$ipr->id.'" class="delete fa fa-trash btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('date', function(Enquiry $ipr) {
                return date('F d, Y', strtotime($ipr->created_at));
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }
}
