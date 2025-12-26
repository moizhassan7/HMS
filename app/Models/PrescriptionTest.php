<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'test_id',
        'type',
        'status',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
    
    // Accessor to get the actual test model
    public function getTestDetailsAttribute()
    {
        if ($this->type === 'pathology') {
            return \App\Models\Test::find($this->test_id);
        } elseif ($this->type === 'radiology') {
            return \App\Models\RadiologyProcedure::find($this->test_id);
        }
        return null;
    }
}
