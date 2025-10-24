<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyData extends Model
{
    use HasFactory;
    protected $table = 'family_data';
    protected $primaryKey = 'id_family';
    protected $fillable = [
        'id_user', 'father_name', 'father_job','mother_name','mother_job',
        'parent_income', 'number_of_children','child_order', 'parent_address', 'parent_phone'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}