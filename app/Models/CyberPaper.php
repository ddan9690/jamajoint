<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CyberPaper extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'paper', 'term', 'year', 'user_id', 'file','slug'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
