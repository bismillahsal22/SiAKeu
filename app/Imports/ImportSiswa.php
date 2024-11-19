<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tahun_Ajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportSiswa implements ToModel, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tahunAjaran = Tahun_Ajaran::where('tahun_ajaran', $row[4])->first();

        if (!$tahunAjaran) {
            // Jika tidak ada, tambahkan tahun ajaran baru ke database
            $tahunAjaran = Tahun_Ajaran::create([
                'tahun_ajaran' => $row[4],
            ]);
        }

         // Cek apakah kelas sudah ada di database
        $kelas = Kelas::where('kelas', $row[3])->first();
        if (!$kelas) {
            // Jika tidak ada, tambahkan kelas baru ke database
            $kelas = Kelas::create([
                'kelas' => $row[3],
            ]);
        }

        if(!array_filter($row)){
            return null;
        }
        
        // Gunakan ID tahun ajaran yang baru atau yang ditemukan
        return new Siswa([
            'nis' => $row[1],
            'nama' => $row[2],
            'kelas' => $kelas->kelas,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '1' => 'required|unique:siswas,nis',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1' => 'Kolom NIS wajib diisi.',
            '2' => 'Kolom nama wajib diisi.',
            '3' => 'Kolom kelas wajib diisi.',
            '4' => 'Kolom tahun ajaran wajib diisi.',
        ];
    }
}