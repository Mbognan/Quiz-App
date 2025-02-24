<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningObjectives extends Model
{
    use HasFactory;




    public function courseOutcome()
    {
        return $this->belongsTo(CourseOutcome::class, 'course_outcome_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
