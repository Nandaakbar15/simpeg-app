<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diklat extends Model
{
    /** @use HasFactory<\Database\Factories\DiklatFactory> */
    protected $table = 'tb_diklat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pegawai_id',
        'nama_diklat',
        'jumlah_jam',
        'penyelenggara',
        'tempat',
        'angkatan',
        'tahun',
        'no_sttpp',
        'tgl_sttpp'
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    use HasFactory;
}
