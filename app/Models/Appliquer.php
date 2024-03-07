<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appliquer extends Model
{
    use HasFactory;

    protected $primaryKey = 'ap_id';
    protected $table = 'appliquer';
}
