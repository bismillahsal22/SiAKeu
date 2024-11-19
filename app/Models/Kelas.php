<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Kelas extends Model
{
    use HasFactory;
    use SearchableTrait;

    protected $primaryKey = 'id_kelas';
    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'kelas' => 10,
        ],
    ];
}