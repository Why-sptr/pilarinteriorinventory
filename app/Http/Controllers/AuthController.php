<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $users = User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('phone_number', 'LIKE', "%{$query}%")
                ->paginate(5);
        } else {
            $users = User::paginate(5);
        }

        return view('listuser', compact('users', 'query'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:users|regex:/^[0-9]{10,12}$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'photo' => 'nullable|image|max:2048',
            'role' => 'required|string|exists:roles,name', // pastikan role ada dalam tabel roles
        ], [
            'name.required' => 'Nama harus diisi.',
            'phone_number.required' => 'Nomor HP harus diisi.',
            'phone_number.unique' => 'Nomor HP sudah digunakan.',
            'phone_number.regex' => 'Nomor HP harus terdiri dari 10 hingga 12 digit.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.max' => 'Gambar harus kurang dari 2MB.',
            'role.required' => 'Silahkan pilih role user',
            'role.exists' => 'Role yang dipilih tidak valid.',
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalName();
            $photo->move(public_path('assets/images/profile'), $photoName);
        }

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $photoName,
        ]);

        // Menetapkan role kepada pengguna yang baru didaftarkan
        $user->assignRole($request->role);

        return redirect('/user')->with('message', 'Registration successful');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return redirect('/')->with('message', 'Login successful');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('message', 'Logout successful');
    }
    public function edit()
    {
        $user = Auth::user();
        return view('admin.editprofile', compact('user'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:users,phone_number,' . Auth::id(),
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'photo' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Nama harus diisi.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'phone_number.unique' => 'Nomor telepon sudah digunakan.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('assets/images/profile/' . $user->photo))) {
                unlink(public_path('assets/images/profile/' . $user->photo));
            }

            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalName();
            $photo->move(public_path('assets/images/profile'), $photoName);
            $user->photo = $photoName;
        }

        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->save();

        return redirect('/edit-profile')->with('message', 'Profile berhasil diupdate');
    }

    public function editid($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edituser', compact('user'));
    }

    public function updateid(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone_number.required' => 'Nomor telepon harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('assets/images/profile/' . $user->photo))) {
                unlink(public_path('assets/images/profile/' . $user->photo));
            }

            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalName();
            $photo->move(public_path('assets/images/profile'), $photoName);
            $user->photo = $photoName;
        }

        $user->save();

        $user->syncRoles([$request->role]);

        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    public function destroyid($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('warning', 'User berhasil dihapus.');
    }
}
