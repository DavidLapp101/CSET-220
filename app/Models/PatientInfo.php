<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class patientinfo extends Model
{
    use HasFactory;

    protected $table = "patientinfo";

    protected $fillable = [
        'userID',
        'familyCode',
        'emergencyContact',
        'contactName',
        'contactRelation',
        'dateOfBirth',
        'admissionDate',
        'balance'
    ];
}
