<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $table = "dailytasks";

    protected $fillable = [
        'date',
        'patientID',
        'morningMed',
        'afternoonMed',
        'eveningMed',
        'breakfast',
        'lunch',
        'dinner',
        'docApt'
    ];
}
