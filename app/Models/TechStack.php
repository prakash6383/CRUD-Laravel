<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechStack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'trainee_id'
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}
