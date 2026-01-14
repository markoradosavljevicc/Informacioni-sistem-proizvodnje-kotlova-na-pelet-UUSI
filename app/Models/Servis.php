<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servis extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kupac_id',
        'proizvod_id',
        'datum_prijave',
        'datum_zavrsetka',
        'opis_kvara',
        'opis_popravke',
        'status',
        'serviser_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'kupac_id' => 'integer',
            'proizvod_id' => 'integer',
            'datum_prijave' => 'date',
            'datum_zavrsetka' => 'date',
            'serviser_id' => 'integer',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }

    public function serviser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'serviser_id');
    }

    public function kupac(): BelongsTo
    {
        return $this->belongsTo(Kupac::class);
    }

    public function proizvod(): BelongsTo
    {
        return $this->belongsTo(Proizvod::class);
    }
}
