<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eselon extends Model
{
    /** @use HasFactory<\Database\Factories\EselonFactory> */
    protected $table = "tb_eselon";
    protected $primaryKey = 'id';
    protected $fillable = ['nama_eselon'];

    public function jabatan()
    {
        return $this->hasOne(Jabatan::class, 'id');
    }

    use HasFactory;
}
