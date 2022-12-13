<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regiment extends Model
{
    use HasFactory;

    protected $fillable = [
        "doctorID",
        "patientID",
        "date",
        "comment",
        "morningMed",
        "afternoonMed",
        "eveningMed"
    ];

}
