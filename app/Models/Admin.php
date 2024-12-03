<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class Admin  extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens, Notifiable, HasRoles;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'password',
        'type',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ===================================================================================================================
    // =========================================== Relationship Section ==================================================
    // ===================================================================================================================

    


    // ===================================================================================================================
    // ============================================== accessories Section ================================================
    // ===================================================================================================================
    public function getStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Active';
        } elseif ($value == 2) {
            return 'Inactive';
        }
    }

    public function getTypeAttribute($value)
    {
        if ($value == 1) {
            return 'Super Admin';
        } elseif ($value == 2) {
            return 'Managment';
        } elseif ($value == 3) {
            return 'Human Resources';
        } elseif ($value == 4) {
            return 'Financial';
        }
    }

    // ===================================================================================================================
    // =============================================== Scopes Section ====================================================
    // ===================================================================================================================
    public function scopeStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    public function isSuperAdmin()
    {
        return $this->is_super_admin === 1;
    }
}
