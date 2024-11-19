<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'akses',
        'nohp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeWali($q)
    {
        return $q->where('akses', 'wali');
    }

    //relasi wali ke siswa->dari tabel user ke siswa
    
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'wali_id', 'id');
    }
    
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'email' => 10,
        ],
    ];

    public function getAllSiswaId(): array
    {
        return $this->siswa()->pluck('id')->toArray();
    }

    // Relasi dengan Tagihan
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_Ajaran::class);
    }

    public function kas()
    {
        return $this->belongsTo(Tahun_Ajaran::class);
    }
}