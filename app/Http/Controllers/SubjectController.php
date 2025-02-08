<?php

namespace App\Http\Controllers;

use App\Models\subject;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    public function index(){
        $subject = subject::all();
        return Inertia::render('Subject',[
            'subject' => $subject,
        ]);
    }

    public function create(Request $request){
            $request->validate([
                'subject_descriptive' => 'required',
                'subject_code' => 'required',
                'subject' => 'required'
            ]);

            try {
              $newSubject  =  Subject::create([
                    'subject' => $request->subject,
                    'subject_code' => $request->subject_code,
                    'subject_abrevation' => $request->subject_descriptive,
                    'status' => 1,
                ]);
                session()->flash('success', 'Subject created successfully');

        // Pass the new subject to the frontend via Inertia
        return Inertia::render('Subject', [
            'subject' => Subject::all(),  // Fetch updated subjects
            'newSubject' => $newSubject   // Optionally send the newly created subject
        ]);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Failed to create subject: ' . $e->getMessage()]); // ✅ Returns an Inertia-compatible error response
            }
    }
}
