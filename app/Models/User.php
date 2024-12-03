<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    // ===================================================================================================================
    // ============================================== Standard Section ===================================================
    // ===================================================================================================================
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_phone_id',
        'status',
        'password',
        'employee_type_id',
        'image',
        'department_id',
        'gender',
        'marital_status',
        'date_of_birth',
        'country_id',
        'city_id',
        'nationality',
        'date_of_hiring',
        'date_termination',
        'address',
        'salary',
        'work_email',
        'work_phone',
        'work_country_phone_id'
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

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function travels()
    {
        return $this->hasMany(Travel::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    // m=>m
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employees');
    }

    public function projectSalesman()
    {
        return $this->hasMany(Project::class, 'project_salesman');
    }


    public function supervisorDesigner()
    {
        return $this->hasMany(Project::class, 'design_supervisor_id');
    }

    public function projectCoordinator()
    {
        return $this->hasMany(Project::class, 'project_project_coordinator_name');
    }

    public function projectWorkingEmployees()
    {
        return $this->hasMany(ProjectWorkingEmployee::class, 'employee_id');
    }


    
    public function employeeType()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }



    // =========== Created By :  Raghad Karasneh================
    public function countryPhoneKey()
    {
        return $this->belongsTo(Country::class, 'country_phone_id');
    }

    public function workCountryPhoneKey()
    {
        return $this->belongsTo(Country::class, 'work_country_phone_id');
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

    // gender
    public function getGenderAttribute($value)
    {
        if ($value == 1) {
            return 'Male';
        } elseif ($value == 2) {
            return 'Female';
        }
    }

    // marital_status
    public function getMaritalStatusAttribute($value)
    {
        if ($value == 1) {
            return 'Single';
        } elseif ($value == 2) {
            return 'Married';
        } elseif ($value == 3) {
            return 'Divorced';
        } elseif ($value == 4) {
            return 'Widow/Widower';
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
