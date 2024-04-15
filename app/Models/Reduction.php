<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reduction extends Model
{
    use HasFactory;

    protected $primaryKey = 'r_id';
    protected $fillable = [
        'r_nom',
        'r_type',
        'r_pourcentage',
    ];

    const UPDATED_AT = null;

    public function vreductions()
    {
        return $this->hasMany(Vreduction::class, 'r_id');
    }
}
