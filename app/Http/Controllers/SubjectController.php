<?php

namespace App\Http\Controllers;

use App\Models\subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index(){
        $subject = subject::all();
        return Inertia::render('Subject',[
            'subject' => $subject,
        ]);
    }

    public function create(Request $request) {
        $request->validate([
            'subject_descriptive' => 'required',
            'subject_code' => 'required',
            'subject' => 'required'
        ]);

        try {
            $subjects = Subject::create([
                'subject' => $request->subject,
                'subject_code' => $request->subject_code,
                'subject_descriptive' => $request->subject_descriptive,
                'status' => 1,
            ]);


            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Subject created successfully',
                    'subject' => $subjects
                ]);
            }

            return Redirect::route('index.subject', compact(['subjects']))->with('success', 'Subject created successfully');

        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'Failed to create subject: ' . $e->getMessage()]);
        }

    }
    public function update($id, Request $request)
    {


        // Check if the subject exists
        $subject = Subject::findOrFail($id);

        // Update the subject data
        $subject->update([
            'subject' => $request->subject,
            'subject_code' => $request->subject_code,
            'subject_descriptive' => $request->subject_descriptive,
            'status' => 1, // or based on input
        ]);

        // Return the updated subject as a response
        return response()->json([
            'message' => 'Subject updated successfully!',
            'subject' => $subject,
        ]);
    }

    public function delete($id){
       try {
        $subject = subject::findOrFail($id);
        $subject->delete();
        return response()->json([
            'message' =>'Subject deleted successfully!',
        ]);
       } catch (\Throwable $th) {
        //throw $th;
       }
    }



}
