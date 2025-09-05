<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stasiun extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "stasiun";
    protected $guarded = ['id'];
}
