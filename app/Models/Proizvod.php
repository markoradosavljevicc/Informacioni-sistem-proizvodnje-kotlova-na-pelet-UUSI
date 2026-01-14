<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proizvod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'naziv',
        'model',
        'tip_goriva',
        'cena',
        'na_stanju',
        'magacin_id',
        'slika',
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
            'cena' => 'decimal:2',
            'magacin_id' => 'integer',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }

    public function magacin(): BelongsTo
    {
        return $this->belongsTo(Magacin::class);
    }

    public function stavkaNarudzbines(): HasMany
    {
        return $this->hasMany(StavkaNarudzbine::class);
    }

    public function servis(): HasMany
    {
        return $this->hasMany(Servis::class);
    }
}
