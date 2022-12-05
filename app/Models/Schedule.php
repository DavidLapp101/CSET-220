<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'supervisor',
        'doctorOne',
        'doctorTwo',
        'doctorThree',
        'groupOneCarer',
        'groupTwoCarer',
        'groupThreeCarer',
        'groupFourCarer',
    ];
}
