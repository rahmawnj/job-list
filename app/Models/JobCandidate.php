<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCandidate extends Model
{
    use HasFactory;

    protected $table = 'job_candidates';
    protected $fillable = [
        'job_id',
        'candidate_id',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function milestones()
    {
        return $this->hasMany(JobCandidateMilestone::class)->orderBy('date', 'asc')->orderBy('id', 'asc');
    }
}
