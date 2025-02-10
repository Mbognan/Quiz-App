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
                'subject_abrevation' => $request->subject_descriptive,
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

}
