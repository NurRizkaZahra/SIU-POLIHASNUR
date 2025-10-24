<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    use HasFactory;
    protected $table = 'personal_data';
    protected $primaryKey = 'id_personal';
    protected $fillable = [
        'id_user','full_name', 'gender', 'place_of_birth','date_of_birth','religion', 
        'nik', 'kk_number', 'phone','address'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
