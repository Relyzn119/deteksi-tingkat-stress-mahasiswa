<?php

use App\Models\Gejala;
use App\Models\User;
use Database\Seeders\SistemPakarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(SistemPakarSeeder::class);
    $this->student = User::where('email', 'mahasiswa@sistempakar.com')->first();
});

test('student can view profile page', function () {
    $response = $this->actingAs($this->student)->get(route('user.profile'));
    $response->assertStatus(200);
});

test('student can update profile information', function () {
    $response = $this->actingAs($this->student)->post(route('user.profile.update'), [
        'nim' => '210101999',
        'name' => 'Mahasiswa Updated',
        'jk' => 'Laki-laki',
        'umur' => 23,
        'prodi' => 'Teknik Informatika',
        'semester' => 8,
    ]);

    $response->assertRedirect(route('diagnosa.create'));
    $this->assertDatabaseHas('users', [
        'id' => $this->student->id,
        'nim' => '210101999',
        'name' => 'Mahasiswa Updated',
    ]);
});

test('student can submit diagnosis and view result', function () {
    $g1 = Gejala::where('kode_gejala', 'G01')->first();
    $g2 = Gejala::where('kode_gejala', 'G02')->first();
    $g4 = Gejala::where('kode_gejala', 'G04')->first();

    $response = $this->actingAs($this->student)->post(route('diagnosa.store'), [
        'gejala' => [
            $g1->id => 1.0,
            $g2->id => 0.8,
            $g4->id => 0.6,
        ],
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('diagnosa', [
        'user_id' => $this->student->id,
    ]);
});

test('student can view diagnosis history', function () {
    $response = $this->actingAs($this->student)->get(route('diagnosa.history'));
    $response->assertStatus(200);
});
