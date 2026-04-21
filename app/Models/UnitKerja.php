<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    /** @use HasFactory<\Database\Factories\UnitKerjaFactory> */
    protected $table = "tb_unit_kerja";
    protected $primaryKey = 'id';
    protected $fillable = ['nama_unit', 'alamat'];

    public function pegawai()
    {
        return $this->hasOne('pegawai_id', Pegawai::class);
    }

    use HasFactory;
}
