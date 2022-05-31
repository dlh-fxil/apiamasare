<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kepegawaian\SubUnit;

class SubUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            //sekretariat

            [
                'unit_id' => "1",
                'jenis' => "Sub Bagian",
                'nama' => "UMUM DAN KEPEGAWAIAN",
                'singkatan' => "UMUM DAN KEPEGAWAIAN",

            ],
            [
                'unit_id' => "1",
                'jenis' => "Seksi",
                'nama' => "PERENCANAAN DAN KEUANGAN",
                'singkatan' => "PERENCANAAN DAN KEUANGAN",

            ],
            // Penataan dan Penaatan Perlindungan dan Pengelolaan Lingkungan Hidup
            [
                'unit_id' => "3",
                'jenis' => "Seksi",
                'nama' => "PERENCANAAN DAN KAJIAN DAMPAK LINGKUNGAN",
                'singkatan' => "PERENCANAAN DAN KAJIAN DAMPAK LINGKUNGAN",

            ],
            [
                'unit_id' => "3",
                'jenis' => "Seksi",
                'nama' => "PENEGAKAN HUKUM LINGKUNGAN dan PENGADUAN DAN PENYELESAIAN SENGKETA",
                'singkatan' => "PENEGAKAN HUKUM LINGKUNGAN dan PENGADUAN DAN PENYELESAIAN SENGKETA",

            ],
            // Pengelolaan Sampah, Limbah dan Pengembangan Kapasitas
            [
                'unit_id' => "4",
                'jenis' => "Seksi",
                'nama' => "PENGELOLAAN SAMPAH DAN PENGEMBANGAN KAPASITAS",
                'singkatan' => "PENGELOLAAN SAMPAH DAN PENGEMBANGAN KAPASITAS",

            ],
            [
                'unit_id' => "4",
                'jenis' => "Seksi",
                'nama' => "SEKSI PENGELOLAAN LIMBAH",
                'singkatan' => "SEKSI PENGELOLAAN LIMBAH",

            ],
            // Pengendalian Pencemaran dan Kerusakan Lingkungan Hidup
            [
                'unit_id' => "2",
                'jenis' => "Seksi",
                'nama' => "Pengendalian Pencemaran dan Kerusakan Lingkungan Hidup",
                'singkatan' => "Pengendalian Pencemaran dan Kerusakan Lingkungan Hidup",

            ],
            [
                'unit_id' => "2",
                'jenis' => "Seksi",
                'nama' => "RTH",
                'singkatan' => "RTH",

            ],

        ];
        foreach ($data as $key => $item) {
            SubUnit::create($item);
        }
    }
}
