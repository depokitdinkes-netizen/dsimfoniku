<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akomodasi extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "akomodasi";
    protected $guarded = ['id'];
}
