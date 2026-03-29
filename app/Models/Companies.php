<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'address', 'industry', 'website', 'owner_id'])]
class Companies extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'companies';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
