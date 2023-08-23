<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rest;

class Work extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'workStart', 'workEnd'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }
}
