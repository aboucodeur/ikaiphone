<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vpaiement extends Model
{
    use HasFactory;
    protected $primaryKey = 'vp_id';

    protected $fillable = [
        'vp_motif',
        'vp_date',
        'vp_montant',
        'vp_etat',
        'v_id',
        'i_id',
    ];

    public function vendre()
    {
        return $this->belongsTo(Vendre::class, 'v_id');
    }

    public function iphone()
    {
        return $this->belongsTo(Iphone::class, 'i_id');
    }
}
