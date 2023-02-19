<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stops extends Model
{
    use HasFactory;

    protected $fillable = [
      'city',
      'agreement'
    ];

    public function city(): BelongsTo {
        $this->belongsTo(City::class);
    }

    public function agreement(): BelongsTo {
        $this->belongsTo(Agreement::class);
    }

    private function hotel(): BelongsToMany {
        $this->belongsToMany(Hotels::class);
    }
}
