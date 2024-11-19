<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipTagihan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(Tahun_Ajaran::class, 'tahun_ajaran_id');
    }

    //menambah atribut
    public function getStatusStyleAttribute()
    {
        if($this->status == 'Baru'){
            return 'primary';
        }
        
        if($this->status == 'Mengangsur'){
            return 'warning';
        }
        if($this->status == 'Lunas'){
            return 'success';
        }
        
    }

    public function pembayaran()
{
    return $this->hasMany(Pembayaran::class, 'arsip_id');
}

}