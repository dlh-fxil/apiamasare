<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kepegawaian\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'jenis' => "Struktural",
                'nama' => "Kepala",
                'singkatan' => "Kadis",
                'kelas' => "100",
            ],
            [
                'jenis' => "Struktural",
                'nama' => "Sekretaris",
                'singkatan' => "Sek",
                'kelas' => "90",
            ],
            [
                'jenis' => "Struktural",
                'nama' => "Kepala Bidang",
                'singkatan' => "Kabid",
                'kelas' => "80",
            ],

            [
                'jenis' => "Struktural",
                'nama' => "Kepala Seksi",
                'singkatan' => "Kasie",
                'kelas' => "70",
            ],
            [
                'jenis' => "Struktural",
                'nama' => "Kepala Sub Bagian",
                'singkatan' => "Kasubag",
                'kelas' => "70",
            ],
            [
                'jenis' => "Fungsional Tertentu",
                'nama' => "Pengendali Lingkungan Hidup",
                'singkatan' => "PLH",
                'kelas' => "10",
            ],
            [
                'jenis' => "Fungsional Tertentu",
                'nama' => "Pengawas Lingkungan Hidup",
                'singkatan' => "PLH",
                'kelas' => "10",
            ],
            [
                'jenis' => "Fungsional Umum",
                'nama' => "Pelaksana",
                'singkatan' => "Pelaksana",
                'kelas' => "10",
            ],

        ];
        foreach ($data as $key => $item) {
            Jabatan::create($item);

            # code...
        }
    }
}
