<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===== RELASI KE DATA PENDAFTARAN CAMABA =====
    public function personalData()
    {
        return $this->hasOne(\App\Models\PersonalData::class, 'id_user');
    }

    public function educationData()
    {
        return $this->hasOne(\App\Models\EducationData::class, 'id_user');
    }

    public function familyData()
    {
        return $this->hasOne(\App\Models\FamilyData::class, 'id_user');
    }

    public function admissionPath()
    {
        return $this->hasOne(\App\Models\AdmissionPath::class, 'id_user');
    }

    public function programSelection()
    {
        return $this->hasOne(\App\Models\ProgramSelection::class, 'user_id');
    }
}
