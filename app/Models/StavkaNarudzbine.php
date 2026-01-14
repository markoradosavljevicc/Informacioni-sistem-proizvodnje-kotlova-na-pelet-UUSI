<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StavkaNarudzbine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'narudzbina_id',
        'proizvod_id',
        'kolicina',
        'cena_jedinice',
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
            'narudzbina_id' => 'integer',
            'proizvod_id' => 'integer',
            'cena_jedinice' => 'decimal:2',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];
    }

    public function narudzbina(): BelongsTo
    {
        return $this->belongsTo(Narudzbina::class);
    }

    public function proizvod(): BelongsTo
    {
        return $this->belongsTo(Proizvod::class);
    }
}
