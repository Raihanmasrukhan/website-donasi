<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use hasfactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    public function fundraisings(){ // kenapa menggunakan s? karna untuk menjelaskan lebih dari satu fundraising
        return $this->hasmany(Fundraising::class);
    }
}
