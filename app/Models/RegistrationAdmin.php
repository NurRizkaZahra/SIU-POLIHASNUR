<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationAdmin extends Model
{
    use HasFactory;

    /**
     * Table name in the database
     */
    protected $table = 'registrations';

    /**
     * Primary key
     */
    protected $primaryKey = 'id';

    /**
     * Fillable columns for mass assignment
     */
    protected $fillable = [
        'full_name',
        'national_id',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'address',
        'province',
        'city',
        'district',
        'postal_code',
        'phone_number',
        'email',
        'father_name',
        'mother_name',
        'father_occupation',
        'mother_occupation',
        'parent_phone',
        'school_origin',
        'graduation_year',
        'school_major',
        'admission_path',
        'chosen_program',
        'photo',
        'diploma',
        'family_card',
        'registration_status',
        'exam_status',
        'exam_date',
        'exam_score',
        'admin_note',
    ];

    /**
     * Column casting
     */
    protected $casts = [
        'birth_date' => 'date',
        'exam_date' => 'datetime',
        'graduation_year' => 'integer',
        'exam_score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'registration_status' => 'pending',
        'exam_status' => 'not_taken',
    ];

    /**
     * Accessor for full name in title case
     */
    public function getFullNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    /**
     * Accessor for formatted birth date
     */
    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date ? $this->birth_date->format('d F Y') : '-';
    }

    /**
     * Accessor for age
     */
    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : 0;
    }

    /**
     * Scope to filter by registration status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('registration_status', $status);
    }

    /**
     * Scope to filter by chosen program
     */
    public function scopeByProgram($query, $program)
    {
        return $query->where('chosen_program', $program);
    }

    /**
     * Scope to filter by admission path
     */
    public function scopeByAdmissionPath($query, $path)
    {
        return $query->where('admission_path', $path);
    }

    /**
     * Scope for applicants who have completed the exam
     */
    public function scopeExamCompleted($query)
    {
        return $query->where('exam_status', 'completed');
    }

    /**
     * Scope for applicants who haven't taken the exam
     */
    public function scopeExamNotTaken($query)
    {
        return $query->where('exam_status', 'not_taken');
    }
}
