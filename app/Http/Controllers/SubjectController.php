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
                Subject::create([
                    'subject' => $request->subject,
                    'subject_code' => $request->subject_code,
                    'subject_abrevation' => $request->subject_descriptive,
                    'status' => 1,
                ]);

                session()->flash('success', 'Subject created successfully');
                return redirect()->route('index.subject');
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Failed to create subject: ' . $e->getMessage()]); // ✅ Returns an Inertia-compatible error response
            }
    }
}
