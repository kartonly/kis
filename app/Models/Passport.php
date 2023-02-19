<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Passport extends Model
{
    use HasFactory;


    protected $fillable = [
        'clientId',
        'pasId',
        'issueOrg',
        'issueDate'
    ];

    protected $casts = [
        'issueDate' => 'date',
    ];

    private function client(): HasOne {
        return $this->hasOne(Clients::class);
    }
}
