<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retour extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 're_id';

    protected $fillable = [
        're_date',
        're_motif',
        'etat',
        'i_id',
        'i_ech_id',
        'en_id'
    ];

    protected $dates = [
        're_date',
    ];

    public function iphoneRetourne()
    {
        return $this->belongsTo(Iphone::class, 'i_id', 'i_id');
    }

    public function iphoneEchange()
    {
        return $this->belongsTo(Iphone::class, 'i_ech_id', 'i_id');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'en_id');
    }
}
