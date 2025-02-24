<?php

namespace App\Http\Controllers;

use App\Models\CourseOutcome;
use App\Models\LearningObjectives;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseOutcomeController extends Controller
{
    public function index(Request $request)
    {


        if ($request->expectsJson()) {
            $courseOutcomes = CourseOutcome::with('subject')->get();

            return response()->json($courseOutcomes);
        }
        // dd(CourseOutcome::with('subject')->get());
        return Inertia::render('CourseOutcome', [
            'course_outcome' => CourseOutcome::with('subject')->get(), // ✅ Fix for missing subject
        ]);


    }

    public function indexLo(Request $request, $id)
    {


        if ($request->expectsJson()) {
            return response()->json([
                'learning_objective' => LearningObjectives::where('course_outcome_id', $id)->with(['subject', 'courseOutcome'])->get(),
            ]);
        }

        return Inertia::render('LearningOutcomestable', [
            'learning_objective' => LearningObjectives::where('course_outcome_id', $id)->with(['subject', 'courseOutcome'])->get(),
        ]);
    }

}
