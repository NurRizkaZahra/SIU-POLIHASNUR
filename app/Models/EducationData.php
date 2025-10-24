<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationData extends Model
{
    use HasFactory;
    protected $table = 'education_data';
    protected $primaryKey = 'id_education';
    protected $fillable = [
        'id_user', 'school_name', 'school_address','major','nisn', 'school_code', 
        'year_of_entry','achievement'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

