<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AkomodasiLain extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "akomodasi_lain";
    protected $guarded = ['id'];
}
