<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class Insurance extends Model
{
    use HasFactory , SoftDeletes;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'insurances';
    protected $fillable = [
        'insurance_type',
        'image',
        'price',
        'status',
    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    public function insuranceBenefits()
    {
        return $this->hasMany(InsuranceBenefit::class, 'insurance_id');
    }
    
    public function insuranceRequests()
    {
        return $this->hasMany(InsuranceRequest::class, 'insurance_id');
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================
    

    // status
    public function getStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Active';
        } elseif ($value == 2) {
            return 'Inactive';
        }
    }

    // insurance_type
    public function getInsuranceTypeAttribute($value)
    {
        if ($value == 1) {
            return 'ضد الغير';
        } elseif ($value == 2) {
            return 'شامل';
        }
    }

    // ===================================================================================================================
    // =============================================== Scopes Section ====================================================
    // ===================================================================================================================

    // status
    public function scopeStatus($query, $value)
    {
        return $query->where('status', $value); // 1 => Active || 2 => Inactive
    }
}
