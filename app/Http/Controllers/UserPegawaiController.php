<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where("role", "pegawai")->get();

        return view("pages.dashboard.manajemen_setup.userPegawai.data_user_pegawai", [
            "user" => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.dashboard.manajemen_setup.userPegawai.tambah_user_pegawai");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        try {
            DB::beginTransaction();

            $validateData['password'] = bcrypt($validateData['password']);
            $validateData['role'] = 'pegawai';

            User::create($validateData);

            DB::commit();

            return redirect('/manajemen_setup/data_user_pegawai')->with('success', 'Berhasil menambahkan akun!');

        } catch(Exception $e) {
            DB::rollBack();

            Log::error("Gagal membuat akun : " . $e->getMessage());

            return back()->withInput()->with('error', 'Error, terjadi kesalahan pada sistem!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
