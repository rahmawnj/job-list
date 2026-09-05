<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplyJob extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
