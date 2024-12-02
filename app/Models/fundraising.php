<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fundraising extends Model
{
    use hasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'fundraiser_id',
        'category_id',
        'thumbnail',
        'about',
        'has_finished',
        'is_active',
        'target_amount'
    ];

    //ORM
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function fundraiser(){ //kita kasih tau kalo dia di miliki oleh beberapa fundraiser misal angga, setiawan
        return $this->belongsTo(Fundraiser::class);
    }

    public function donaturs() { 
        return $this->hasMany(Donatur::class)->where('is_paid', 1);
    } //dan dia juga di miliki oleh beberapa donaturs di dalam 1 fundraising dan kita juga menambahkan aksi ( where ) karna org yg di sebut donatur apabila pembayaranya sudah aktif klo dia udah bayar tp masih pending, itu blm bisa kita sebut donaturs

    public function totalReachedAmount() {
        return $this->donaturs()->sum('total_amount');
    }// totalReachedAmount di gunakan untuk menghitung

    public function withdrawals() {
        return $this->hasMany(FundraisingWithdrawal::class);
    }// di gunakan untuk penarikan dana apabila dana terpenuhi

    public function fundraising_phases() {
        return $this->hasMany(Fundraisingphase::class);
    }

    public function getPercentageAttribute() {
        $totalDonations = $this->totalReachedAmount();
        if($this->target_amount > 0) {
            $percentage = ($totalDonations / $this->target_amount) * 100; //88
            return $percentage > 100 ? 100 : $percentage;
        }
        return 0;
    }
    
}
