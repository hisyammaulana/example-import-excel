<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasSiswa extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}
