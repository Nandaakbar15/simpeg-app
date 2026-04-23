<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    /** @use HasFactory<\Database\Factories\JabatanFactory> */
    protected $table = 'tb_jabatan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pegawai_id',
        'master_jabatan_id',
        'eselon_id',
        'jenis_jabatan',
        'periode',
        'tahun_ke',
        'no_sk',
        'tgl_sk',
        'terbit'
    ];

    public function master_jabatan()
    {
        return $this->belongsTo(MasterJabatan::class, 'master_jabatan_id');
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class, 'eselon_id');
    }


    use HasFactory;
}
