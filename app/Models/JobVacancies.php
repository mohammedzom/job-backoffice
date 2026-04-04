<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['company_id', 'title', 'description', 'salary', 'location', 'type', 'status', 'application_deadline', 'technologies', 'view_count', 'apply_count'])]
class JobVacancies extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected function casts()
    {
        return [
            'deleted_at' => 'datetime',
            'technologies' => 'array',
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(JobCategory::class, 'category_job', 'job_id', 'category_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplications::class, 'job_id', 'id');
    }
}
