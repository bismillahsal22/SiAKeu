<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Attribute;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tagihan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;
    
    public $guarded = [];
    protected $dates = ['tgl_tagihan', 'tgl_jatuh_tempo'];
    protected $with = ['user', 'siswa', 'tahun_ajaran', 'kelas', 'detailTagihan'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    
    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_Ajaran::class, 'tahun_ajaran_id');
    }
    
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    protected static function booted()
    {
        static::creating(function($tagihan){
            $tagihan->user_id = auth()->user()->id;
        });

        static::updating(function($tagihan){
            $tagihan->user_id = auth()->user()->id;
        });
    }

    public function detailTagihan()
    {
        return $this->hasMany(DetailTagihan::class);
    }
    
    
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
    
    public function getStatusTagihanWali()
    {
        if($this->status == 'Baru'){
            return 'Belum Membayar';
        }
        if($this->status == 'Lunas'){
            return 'Sudah Membayar';
        }
        return $this->status;
    }

    public function scopeWaliSiswa($q)
    {
        return $q->whereIn('siswa_id', Auth::user()->getAllSiswaId());
    }
    
    protected $searchable = [
        'columns' => [
            'nama' => 10,
            'nis' => 10,
        ],
    ];

    public function arsipTagihan()
    {
        return $this->belongsTo(ArsipTagihan::class);
    }
}