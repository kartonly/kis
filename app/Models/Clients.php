<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rules\In;

class Clients extends Model
{
    use HasFactory;


    protected $fillable = [
        'first_name',
        'last_name',
        'second_name',
        'gender',
        'city',
        'status',
        'birth_date'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function passport(): HasOne {
        $this->hasOne(Passport::class);
    }

    public function intPassport(): HasOne {
        $this->hasOne(IntPassport::class);
    }

    public function preagreement(): HasMany {
        $this->hasMany(Preagreement::class);
    }

    public function agreement(): HasMany {
        $this->hasMany(Agreement::class);
    }
}
