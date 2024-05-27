<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fournisseur extends Model
{
    use HasFactory;
    use SoftDeletes; // enables soft delete

    protected $primaryKey = 'f_id';

    protected $fillable = [
        'f_nom',
        'f_tel',
        'f_adr',
        'en_id'
    ];

    public function achats()
    {
        return $this->hasMany(Achat::class, 'f_id', 'f_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'en_id');
    }
}
