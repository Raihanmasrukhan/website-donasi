<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fundraisingphase extends Model
{
    use hasfactory, SoftDeletes;

    protected $fillable = [
        'name',
        'notes',
        'fundraising_id',
        'photo',
    ];
}
