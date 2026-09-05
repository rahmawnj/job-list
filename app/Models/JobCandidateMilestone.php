<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCandidateMilestone extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jobCandidate()
    {
        return $this->belongsTo(JobCandidate::class);
    }
}
