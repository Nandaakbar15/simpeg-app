<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('role', 'admin')->get();

        return view('pages.dashboard.manajemen_setup.userAdmin.data_user_admin', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.manajemen_setup.userAdmin.tambah_user_admin');
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
            'password' => 'required|string',
        ]);

        $validateData['password'] = bcrypt($validateData['password']);
        $validateData['role'] = 'admin';

        User::create($validateData);

        return redirect('/manajemen_setup/data_user_admin')->with('success', 'Berhasil menabahkan data user admin!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("pages.dashboard.manajemen_setup.userAdmin.edit_user_admin", [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validateData = $request->validate([
            'username' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
        ]);

        $validateData['role'] = 'admin';

        $user->update($validateData);

        return redirect('/manajamen_setup/data_user_admin')->with('success', 'Berhasil mengubah data user admin!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
