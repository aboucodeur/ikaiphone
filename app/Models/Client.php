<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes; // enables soft delete

    protected $primaryKey = 'c_id';

    protected $fillable = [
        'c_nom',
        'c_tel',
        'c_adr',
        'c_type',
    ];

    public function vendres()
    {
        return $this->hasMany(Vendre::class, 'c_id');
    }
}
