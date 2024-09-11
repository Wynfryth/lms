<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Studies extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tm_study_material_header';

    public $timestamps = false;
    protected $hidden = ['deleted_at'];

    protected $fillable = [
        'study_material_title',
        'study_material_desc',
        'category_id',
        'is_released',
        'is_active',
        'created_by',
        'modified_by'
    ];
}
