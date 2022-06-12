<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kepegawaian\Unit;

class UnitSeeder extends Seeder
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
                'jenis' => "Sekretariat",
                'nama' => "Sekretariat",
                'uraian_tugas_fungsi' => "uraian_tugas_fungsi Sekretariat",
                'singkatan' => "Sek",

            ],
            [
                'jenis' => "Bidang",
                'nama' => "Penataan dan Penaatan Perlindungan dan Pengelolaan Lingkungan Hidup",
                'uraian_tugas_fungsi' => "uraian_tugas_fungsi Penataan dan Penaatan Perlindungan dan Pengelolaan Lingkungan Hidup",
                'singkatan' => "PPPPLH",
            ],
            [
                'jenis' => "Bidang",
                'nama' => "Pengelolaan Sampah, Limbah dan Pengembangan Kapasitas",
                'uraian_tugas_fungsi' => "Pengelolaan Sampah, Limbah dan Pengembangan Kapasitas",
                'singkatan' => "Pengelolaan Sampah, Limbah dan Pengembangan Kapasitas",
            ],
            [
                'jenis' => "Bidang",
                'nama' => "Pengendalian Pencemaran dan Kerusakan Lingkungan Hidup",
                'uraian_tugas_fungsi' => "uraian_tugas_fungsi Pengendalian Pencemaran dan Kerusakan Lingkungan Hidup",
                'singkatan' => "PPKLH",
            ],

        ];
        foreach ($data as $key => $item) {
            Unit::create($item);
        }
    }
}
