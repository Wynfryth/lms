<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class ClassCat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tm_class_category';

    protected $fillable = [
        'class_category',
        'desc',
        'is_active',
        'created_by',
        'modified_by'
    ];
}
