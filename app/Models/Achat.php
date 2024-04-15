<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
    use HasFactory;
    protected $primaryKey = 'a_id';

    protected $fillable = [
        'a_date',
        'a_etat',
        'f_id',
    ];

    protected $dates = [
        'a_date',
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'f_id', 'f_id');
    }

    // relaion (n,n) sans creer le table de liaison
    public function iphones()
    {
        return $this->belongsToMany(Iphone::class, 'acommandes', 'a_id', 'i_id')
                    ->withPivot('ac_id', 'ac_etat', 'ac_qte', 'ac_prix');
    }

}
