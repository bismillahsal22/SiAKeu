<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tahun_Ajaran extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $guarded = [];
    protected $dates = ['tgl_mulai', 'tgl_akhir'];
    protected $searchable = [
        'columns' => [
            'tahun_ajaran' => 10,
        ],
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'tahun_ajaran_id');
    }

    // Jika ingin menambahkan relasi dari TahunAjaran ke Siswa
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'tahun_ajaran_id');
    }

    // Method untuk mengambil tahun ajaran yang aktif
    public static function getActiveYear()
    {
        return self::where('status', 'aktif')->first();
    }
}