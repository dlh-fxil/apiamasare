<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Kepegawaian\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $nip = null;
        for ($i = 0; $i < 60; $i++) {
            if ($i < 20) {
                $selectJK = 'PNS';
                $aa  = strtotime('-40 year');
                $bb  = strtotime('-20 year');
                $cc  = strtotime('-10 year');
                $dd  = strtotime('-1 year');
                $date1 = rand($aa, $bb);
                $date2 = rand($cc, $dd);
                $jeniskelamin =  rand(1, 2);
                $kode = sprintf("%03s", rand(1, 100));
                $nip = date('Ymd', $date1) .  date('Ymd', $date2) . $jeniskelamin . $kode;
            } elseif ($i < 40) {
                $selectJK = 'PPNPNS';
            } else {
                $selectJK = 'P3K';
            }

            $pegawai =  [
                'nama' => Str::random(20),
                'jenis_pegawai' => $selectJK,
                'nip' => $nip,
                'no_hp' => sprintf("%012s", rand(81000000000, 89999999999)),
                'no_wa' => sprintf("%012s", rand(81000000000, 89999999999)),
                'eselon' => Str::random(4),
                'pangkat_id' => rand(1, 17),
                'jabatan_id' => rand(1, 7),
                'unit_id' => rand(1, 4),
                'sub_unit_id' => rand(1, 2),
                'created_at' =>  date('Y-m-d H:i:s', strtotime(now())),
                'updated_at' =>  date('Y-m-d H:i:s', strtotime(now())),
            ];
            Pegawai::insert($pegawai);
        }
    }
}
