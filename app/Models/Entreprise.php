<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entreprise extends Model
{
    use HasFactory;
    protected $primaryKey = 'en_id';

    protected $fillable = ['en_nom', 'en_desc', 'en_tel', 'en_adr', 'en_logo', 'en_id'];

    // ** Ses Relations

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'en_id');
    }

    public function modeles(): HasMany
    {
        return $this->hasMany(Modele::class, 'en_id');
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'en_id');
    }

    public function fournisseurs(): HasMany
    {
        return $this->hasMany(Fournisseur::class, 'en_id');
    }

    public function retours(): HasMany
    {
        return $this->hasMany(Retour::class, 'en_id');
    }
}
