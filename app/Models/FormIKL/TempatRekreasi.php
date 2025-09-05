<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempatRekreasi extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "tempat_rekreasi";
    protected $guarded = ['id'];
}
