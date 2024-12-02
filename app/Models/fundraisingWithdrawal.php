<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fundraisingWithdrawal extends Model
{
    use hasfactory, SoftDeletes;

    protected $fillable = [
        'fundraising_id',
        'fundraiser_id',
        'has_received',
        'has_sent',
        'amount_requested',
        'proof',
        'amount_received',
        'bank_account_name',
        'bank_name',
        'bank_account_number',
    ];

    public function fundraiser() {
        return $this->belongsTo(Fundraiser::class);
    }// untuk melihat siapa yg mengambil dana

    public function fundraising() {
        return $this->belongsTo(Fundraising::class);
    }//untuk melihat tujuan doanasi untuk apa
}
