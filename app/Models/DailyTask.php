<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'patientID',
        'morningMed',
        'eveningMed',
        'breakfast',
        'lunch',
        'dinner',
    ];
}
