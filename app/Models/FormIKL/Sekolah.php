<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "sekolah";
    protected $guarded = ['id'];
}
