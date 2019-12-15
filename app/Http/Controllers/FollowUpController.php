<?php

namespace App\Http\Controllers;

use App\FollowUp;
use App\Services\FollowUpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class FollowUpController extends Controller
{
    protected $followUpService;

    public function __construct(FollowUpService $followUpService)
    {
        $this->followUpService = $followUpService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('follow-up.manage-follow-up');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('follow-up.add-follow-up');
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
            $this->followUpService->store($validatedData, Auth::user()->id);

            return redirect('/follow-up')->with([
                'type' => 'success',
                'title' => 'follow-up added successfully',
                'message' => 'The given follow-up has been added successfully'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed to add the follow-up',
                'message' => "There was some issue in adding the follow-up"
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
            $followup = FollowUp::findOrFail($id);
            return view('follow-up.view-follow-up')->with(
                [
                    'follow_up' => $followup
                ]
            );
        } catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed To show follow-up',
                'message' => 'Error in viewing follow-up'
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
        $ipr = FollowUp::find($id);
        return view('follow-up.edit-follow-up')->with('follow-up', $ipr);
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
            return redirect('/follow-up')->with([
                'type' => 'success',
                'title' => 'follow-up updated successfully',
                'message' => 'The given follow-up has been updated successfully'
            ]);
        }

        return redirect()->back()->with([
            'type' => 'danger',
            'title' => 'Failed to update the follow-up',
            'message' => "There was some issue in updating the follow-up"
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
            $this->followUpService->delete($id);
            return redirect()->back()->with([
                'type' => 'success',
                'title' => 'follow-up Deleted successfully',
                'message' => 'The given follow-up has been deleted successfully'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed To Delete follow-up',
                'message' => 'Error in deleting follow-up'
            ]);
        }
    }

    public function getfollowUp() {
        /*CURRENT USER PUBLISHED BOOKS*/
        $followup = $this->followUpService->getDatatable();

        return DataTables::of($followup)
            ->addColumn('edit', function(FollowUp $followup) {
                return '<button data-follow-upid="'.$followup->id.'" class="edit fa fa-pencil-alt btn-sm btn-warning" data-toggle="modal" data-target="#editModal"></button>';
            })
            ->addColumn('delete', function(FollowUp $followup) {
                return '<button data-follow-upid="'.$followup->id.'" class="delete fa fa-trash btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('view', function(FollowUp $followup) {
                return '<a href="/follow-up/'.$followup->id.'" class="fa fa-search btn-sm btn-success"></a>';
            })
            ->rawColumns(['edit', 'delete', 'view'])
            ->make(true);
    }
}
