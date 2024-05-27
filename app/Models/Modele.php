<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modele extends Model
{
    use HasFactory;
    use SoftDeletes; // enable soft deletion

    protected $primaryKey = 'm_id';

    protected $fillable = [
        'm_nom',
        'm_type',
        'm_memoire',
        'm_qte',
        'm_prix',
        'en_id'
    ];

    public function iphones(): HasMany
    {
        return $this->hasMany(Iphone::class, 'm_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'en_id');
    }
}
