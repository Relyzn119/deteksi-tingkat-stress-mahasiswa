<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminMahasiswaController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->query('search');

        $query = User::where('role', 'user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('prodi', 'like', "%{$search}%");
            });
        }

        $mahasiswaList = $query->orderBy('id', 'desc')->get();

        return Inertia::render('Admin/Mahasiswa/Index', [
            'mahasiswaList' => $mahasiswaList,
            'search' => $search,
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = User::where('role', 'user')->where('id', $id)->firstOrFail();
        $user->delete();

        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
