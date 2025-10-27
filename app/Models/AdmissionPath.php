<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionPath extends Model
{
    use HasFactory;

    protected $table = 'admission_paths';
    protected $primaryKey = 'id_path';
    protected $fillable = [
        'id_user',     // ubah dari id_user ke user_id
        'path_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
