<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Initiative extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'impact_score',
        'category',
    ];

    protected $casts = [
        'impact_score' => 'integer',
    ];
}
