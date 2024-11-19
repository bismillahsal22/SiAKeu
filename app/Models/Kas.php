<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $guarded = [];

    protected $dates = ['tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}