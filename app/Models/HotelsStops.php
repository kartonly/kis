<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelsStops extends Model
{
    use HasFactory;

    protected $fillable = [
        'stopId',
        'hotelId',
    ];
    public $timestamps = false;
}
