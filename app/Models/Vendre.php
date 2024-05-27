<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendre extends Model
{
    use HasFactory;
    protected $primaryKey = 'v_id';

    protected $fillable = [
        'v_date',
        'v_type',
        'v_etat',
        'c_id',
    ];

    protected $dates = [
        'v_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'c_id');
    }

    public function paiements()
    {
        return $this->hasMany(Vpaiement::class, 'v_id');
    }

    // (n,n)
    public function iphones()
    {
        return $this->belongsToMany(Iphone::class, 'vcommandes', 'v_id', 'i_id')
            ->withPivot('vc_id', 'vc_etat', 'vc_qte', 'vc_prix', 'created_at', 'updated_at');
        // ->withPivot('vc_id', 'vc_etat', 'vc_qte', 'vc_prix', 'vc_color', 'created_at', 'updated_at');
    }

    public function vreductions()
    {
        return $this->belongsToMany(Vreduction::class, 'appliquer', 'v_id', 'vr_id')
            ->withPivot('ap_id');
    }
}
