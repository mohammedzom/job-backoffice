<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['job_id', 'user_id'])]
class JobUserViews extends Model
{
    public function job()
    {
        return $this->belongsTo(JobVacancies::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
