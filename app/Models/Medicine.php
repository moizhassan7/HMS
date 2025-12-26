<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'generic_name',
        'manufacturer',
        'category_id',
        'location_id',
        'min_stock_level',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function stocks()
    {
        return $this->hasMany(PharmacyStock::class);
    }
}
