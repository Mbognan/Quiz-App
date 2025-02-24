<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseOutcome;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model

{
    use HasFactory;
    protected $fillable = [
        'subject',
        'subject_code',
        'subject_descriptive',
        'status'
    ];

    public function courseOutcomes()
    {
        return $this->hasMany(CourseOutcome::class, 'subject_id', 'id');
    }

    public function learningObjective(){
        return $this->hasMany(LearningObjectives::class);
    }


}
