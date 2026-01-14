<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Narudzbina extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kupac_id',
        'datum_narudzbine',
        'rok_isporuke',
        'status',
        'ukupna_cena',
        'napomena',
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
            'datum_narudzbine' => 'date',
            'rok_isporuke' => 'date',
            'ukupna_cena' => 'decimal:2',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }

    public function kupac(): BelongsTo
    {
        return $this->belongsTo(Kupac::class);
    }

    public function stavkaNarudzbines(): HasMany
    {
        return $this->hasMany(StavkaNarudzbine::class);
    }
}
