<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ClassCat extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'tm_class_category';

    protected $fillable = [
        'class_category',
        'desc',
        'is_active',
        'created_by',
        'modified_by'
    ];
}
