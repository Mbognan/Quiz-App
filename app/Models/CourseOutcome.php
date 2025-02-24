<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CourseOutcome extends Model
{
    use HasFactory;

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function learningObjective(){
        return $this->haMany(LearningObjectives::class);
    }

}
