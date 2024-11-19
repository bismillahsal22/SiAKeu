<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class TagihanOperator extends Model
{
    use HasFactory;
    use SearchableTrait;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Tahun_Ajaran
    public function tahun_ajaran()
    {
        return $this->belongsTo(Tahun_Ajaran::class, 'tahun_ajaran_id');
    }

    // Relasi dengan Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    protected $searchable = [
        'columns' => [
            'nama' => 10,
            'nisn' => 10,
        ],
    ];
    
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
}