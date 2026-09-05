<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\District;

class Jobcategory extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];
    protected $casts = [
        'is_top_category' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
