<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

class Siswa extends Model
{
    use HasFactory;
    use SearchableTrait;
    use HasStatuses;
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model TahunAjaran
    public function tahunAjaran()
    {
        return $this->belongsTo(Tahun_Ajaran::class, 'tahun_ajaran_id');
    }
    

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id')->withDefault([
            'name' => 'Belum Ada Wali Siswa'
        ]);
    }

    protected $append = ['ttl'];

    /**
     * Interact with the user's first name.
     */
    protected function ttl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tempat_lahir . ', ' . Carbon::parse($this->tgl_lahir)->format('d - F - Y'),
        );
    }

    protected $searchable = [
        'columns' => [
            'nama' => 10,
            'nis' => 10,
        ],
    ];
    
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function pembayaran()
    {
        return $this->hasManyThrough(Pembayaran::class, Tagihan::class, 'siswa_id', 'tagihan_id');
    }

    public function arsipTagihan()
    {
         return $this->hasOne(ArsipTagihan::class);
    }
}