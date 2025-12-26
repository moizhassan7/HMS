<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_test_id',
        'radiologist_id',
        'report_text',
        'image_path',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function prescriptionTest()
    {
        return $this->belongsTo(PrescriptionTest::class);
    }

    public function radiologist()
    {
        return $this->belongsTo(User::class, 'radiologist_id');
    }
}
