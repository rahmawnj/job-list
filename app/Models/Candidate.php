<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function jobCandidates()
    {
        return $this->hasMany(JobCandidate::class);
    }
}
