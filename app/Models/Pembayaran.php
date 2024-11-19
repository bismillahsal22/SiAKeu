<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Pembayaran extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;
    
    protected $guarded = [];
    protected $dates = ['tgl_bayar', 'tgl_konfirmasi'];
    protected $with = ['user', 'tagihan'];
    protected $append = ['status_konfirmasi'];

    public function getStatusStyleAttribute()
    {
        if($this->tgl_konfirmasi == null){
            return 'danger';
        }
        
        return 'success';
    }

    /**
     * Interact with the user's first name.
     */
    protected function statusKonfirmasi(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->tgl_konfirmasi == null) ? 'Belum Dikonfirmasi' : 'Sudah Dikonfirmasi'
        );
    }
    
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function wali():BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    
    public function bankSekolah()
    {
        return $this->belongsTo(BankSekolah::class);
    }
    
    
    public function waliBank()
    {
        return $this->belongsTo(WaliBank::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(Tahun_Ajaran::class, 'tahun_ajaran_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class); 
    }

    public function arsipTagihan()
    {
        return $this->belongsTo(ArsipTagihan::class);
    }
    
    protected $searchable = [
        'columns' => [
            'nama' => 10,
            'nis' => 10,
        ],
    ];
}