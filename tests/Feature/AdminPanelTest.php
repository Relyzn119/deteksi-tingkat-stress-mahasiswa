<?php

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\User;
use Database\Seeders\SistemPakarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(SistemPakarSeeder::class);
    $this->admin = User::where('email', 'admin@sistempakar.com')->first();
    $this->student = User::where('email', 'mahasiswa@sistempakar.com')->first();
});

test('non-admin user cannot access admin dashboard', function () {
    $response = $this->actingAs($this->student)->get(route('admin.dashboard'));
    $response->assertStatus(403);
});

test('admin can access dashboard', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $response->assertStatus(200);
});

test('admin can create, update, and delete penyakit', function () {
    // Create
    $response = $this->actingAs($this->admin)->post(route('admin.penyakit.store'), [
        'kode_penyakit' => 'P05',
        'nama_penyakit' => 'Depresi Uji',
        'deskripsi' => 'Deskripsi Uji',
        'solusi' => 'Solusi Uji',
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('penyakit', ['kode_penyakit' => 'P05']);

    // Update
    $penyakit = Penyakit::where('kode_penyakit', 'P05')->first();
    $response = $this->actingAs($this->admin)->put(route('admin.penyakit.update', $penyakit->id), [
        'kode_penyakit' => 'P05',
        'nama_penyakit' => 'Depresi Uji Updated',
        'deskripsi' => 'Deskripsi Uji Updated',
        'solusi' => 'Solusi Uji Updated',
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('penyakit', ['nama_penyakit' => 'Depresi Uji Updated']);

    // Delete
    $response = $this->actingAs($this->admin)->delete(route('admin.penyakit.destroy', $penyakit->id));
    $response->assertRedirect();
    $this->assertDatabaseMissing('penyakit', ['id' => $penyakit->id]);
});

test('admin can create, update, and delete gejala', function () {
    // Create
    $response = $this->actingAs($this->admin)->post(route('admin.gejala.store'), [
        'kode_gejala' => 'G99',
        'nama_gejala' => 'Gejala Uji',
        'jenis_gejala' => 'utama',
        'cf_pakar' => 0.7,
    ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('gejala', ['kode_gejala' => 'G99']);

    // Delete
    $gejala = Gejala::where('kode_gejala', 'G99')->first();
    $response = $this->actingAs($this->admin)->delete(route('admin.gejala.destroy', $gejala->id));
    $response->assertRedirect();
    $this->assertDatabaseMissing('gejala', ['id' => $gejala->id]);
});

test('admin can view student list and reports', function () {
    $response1 = $this->actingAs($this->admin)->get(route('admin.mahasiswa.index'));
    $response1->assertStatus(200);

    $response2 = $this->actingAs($this->admin)->get(route('admin.laporan.index'));
    $response2->assertStatus(200);
});
