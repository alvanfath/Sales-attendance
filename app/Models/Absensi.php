<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'absensi';
    protected $fillable = [
        'sales_id',
        'image',
        'location',
        'in_time',
        'out_time',
        'place_name',
        'last_location'
    ];

    public function sales(){
        return $this->belongsTo(User::class, 'sales_id', 'id');
    }
}
