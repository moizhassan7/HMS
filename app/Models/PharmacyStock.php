<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'medicine_name',
        'batch_number',
        'quantity_available',
        'expiry_date',
        'price_per_unit',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price_per_unit' => 'decimal:2',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
