<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Kepegawaian\UraianTugas;

class UraianTugasSeeder extends Seeder
{
 /**
  * Run the database seeds.
  *
  * @return void
  */
 public function run()
 {



  for ($i = 1; $i < 9; $i++) {
   for ($j = 0; $j < 2; $j++) {
    if ($j === 0) {
     $selectJenis = 'Tugas Pokok';
     for ($k = 0; $k < 10; $k++) {
      $pegawai =  [
       'jabatan_id' => $i,
       'jenis_tugas' => $selectJenis,
       'uraian_tugas' => 'uraian_tugas ' . Str::random(20),
       'indikator' => 'Indikator ' . Str::random(20),
       'angka_kredit' => rand(0, 1),
       'keterangan' => 'Keterangan ' . Str::random(20),

      ];
      UraianTugas::create($pegawai);
     }
    } else {
     $selectJenis = 'Tugas Tambahan';
     for ($k = 0; $k < 2; $k++) {
      $pegawai =  [
       'jabatan_id' => $i,
       'jenis_tugas' => $selectJenis,
       'uraian_tugas' => 'uraian_tugas ' . Str::random(20),
       'indikator' => 'Indikator ' . Str::random(20),
       'angka_kredit' => rand(0, 1),
       'keterangan' => 'Keterangan ' . Str::random(20),

      ];
      UraianTugas::create($pegawai);
     }
    }
   }
  }
 }
}
