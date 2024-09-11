<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyCat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tm_study_material_category';

    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'study_material_category',
        'desc',
        'is_active',
        'created_by',
        'modified_by'
    ];
}
