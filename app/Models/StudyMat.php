<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyMat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tm_study_material_detail';

    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'name',
        'header_id',
        'order',
        'is_active',
        'created_by',
        'created_date',
        'modified_by',
        'modified_date',
        'scoring_weight'
    ];
}
