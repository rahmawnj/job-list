<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $softDelete = true;
   
  
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function jobcategory()
    {
        return $this->belongsTo(Jobcategory::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function applyjobs()
    {
        return $this->hasMany(ApplyJob::class);
    }

    public function jobCandidates()
    {
        return $this->hasMany(JobCandidate::class);
    }
}
