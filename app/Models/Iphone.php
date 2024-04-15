<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iphone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'i_id';

    protected $fillable = [
        'i_barcode',
        'm_id',
    ];

    // relation (1,1)
    public function modele(): BelongsTo
    {

        return $this->belongsTo(Modele::class, 'm_id');
    }

    // relation (0,n)
    public function paiements()
    {
        return $this->hasMany(Vpaiement::class, 'i_id');
    }

    // relation (n,n) table de pivot pour faciliter la gestion
    public function achats()
    {
        return $this->belongsToMany(Achat::class, 'acommandes', 'i_id', 'a_id')
            ->withPivot('ac_id', 'ac_etat', 'ac_qte', 'ac_prix');
    }

    public function ventes()
    {
        return $this->belongsToMany(Vendre::class, 'vcommandes', 'i_id', 'v_id')
            ->withPivot('vc_id', 'vc_etat', 'vc_qte', 'vc_prix', 'created_at', 'updated_at');
    }

    public function retour()
    {
        return $this->hasOne(Retour::class, 'i_id');
    }
}
