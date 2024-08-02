<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 't_classes';

    protected $fillable = [
        'class_code',
        'class_category_id',
        'class_title',
        'class_desc',
        'class_period',
        'tc_id',
        'is_active',
        'start_eff_date',
        'end_eff_date',
        'loc_type_id',
        'created_by'
    ];

    public function classCategory()
    {
        return $this->belongsTo(ClassCat::class, 'id');
    }

    public function trainingCenter()
    {
        return $this->belongsTo(TrainCt::class, 'id');
    }

    public function locType()
    {
        return $this->belongsTo(LocType::class, 'id');
    }
}
