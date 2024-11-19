<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Jenis_Pembayaran extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;
    
    protected $guarded = [];

    protected $append = ['jenis_bayar_full', 'total_tagihan'];

    /**
     * Interact with the user's first name.
     */
    protected function JenisBayarFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama . ' - ' . $this->formatRupiah('jumlah'),
        );
    }

    /**
     * Interact with the user's first name.
     */
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->children->sum('jumlah'),
        );
    }

    public function children()
    {
        return $this->hasMany(Jenis_Pembayaran::class, 'parent_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected static function booted()
    {
        static::creating(function($jp){
            $jp->user_id = auth()->user()->id;
        });

        static::updating(function($jp){
            $jp->user_id = auth()->user()->id;
        });
    }

    protected $searchable = [
        'columns' => [
            'nama' => 10,
        ],
    ];
}