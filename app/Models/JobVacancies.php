<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['company_id', 'category_id', 'title', 'description', 'salary'])]
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
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(JobCategories::class, 'category_job');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }
}
