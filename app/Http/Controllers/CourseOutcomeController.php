<?php

namespace App\Http\Controllers;

use App\Models\CourseOutcome;
use App\Models\LearningObjectives;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseOutcomeController extends Controller
{
    public function index(Request $request){
        if ($request->expectsJson()) {
            return response()->json(CourseOutcome::all()); // ✅ Return JSON when API is called
        }

        return Inertia::render('CourseOutcome', [
            'course_outcome' => CourseOutcome::all(),
        ]);
    }
    public function indexLo($id)
    {
        return Inertia::render('LearningOutcomestable', [
            'learning_objectives' => LearningObjectives::where('course_outcome_id', $id)->get(),
        ]);
    }
}
