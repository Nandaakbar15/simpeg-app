<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    protected $table = "tb_pegawai";
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'foto',
        'nip',
        'nama',
        'gelar',
        'tmpt_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'agama',
        'golongan_darah',
        'status_pernikahan',
        'alamat',
        'no_hp',
        'email',
        'email_gov',
        'no_npwp',
        'no_bpjs',
        'status_kepegawaian',
        'karpeg',
        'no_sk_cpns',
        'tmt_pns',
        'no_sk_pns',
        'tmt_pns',
        'gol_awal',
        'nilai_tpp'
    ];

    public function user()
    {
        return $this->belongsTo('user_id', User::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo('unit_kerja_id', UnitKerja::class);
    }

    use HasFactory;
}
