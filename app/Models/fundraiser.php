<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fundraiser extends Model
{
    use hasfactory, SoftDeletes;

    protected $fillable = [
        'is_active',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    } // untuk melihat biodata, email dan poto dari user
}
