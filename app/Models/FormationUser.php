<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'formation_id',
    ];
    protected $table = 'formation_user';
}
