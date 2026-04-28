<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterGolongan extends Model
{
    /** @use HasFactory<\Database\Factories\MasterGolonganFactory> */
    protected $table = 'tb_master_golongan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_golongan'];

    public function golongan()
    {
        return $this->hasOne(Golongan::class, 'id');
    }

    use HasFactory;
}
