<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donatur extends Model
{
    use hasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'notes',
        'fundraising_id',
        'total_amount',
        'phone_number',
        'is_paid',
        'proof',
    ];
 public function fundraising(){
    return $this->belongsTo(Fundraising::class, 'id');
 }// hanya di miliki oleh 1 fundraising




}
