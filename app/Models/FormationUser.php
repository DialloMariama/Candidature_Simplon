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
        'etat',
    ];
    protected $table = 'formation_user';
    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
