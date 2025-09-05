<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SumurBorPompa extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "sumur_bor_pompa";
    protected $guarded = ['id'];
}
