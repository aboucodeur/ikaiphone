<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vreduction extends Model
{
    use HasFactory;
    protected $primaryKey = 'vr_id';

    protected $fillable = [
        'vr_etat',
        'r_id',
    ];

    public function reduction()
    {
        return $this->belongsTo(Reduction::class, 'r_id', 'r_id');
    }

    // n,n
    public function vendres()
    {
        return $this->belongsToMany(Vendre::class, 'appliquer', 'vr_id', 'v_id')
            ->withPivot('ap_id');
    }
}
