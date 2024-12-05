<?php

namespace App\Imports;

use App\Models\DetailTagihan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportTagihan implements ToModel, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //Skip jika baris kosong
        if (!array_filter($row)) {
           return null;
        }

        //Cek apakah kelas sudah ada di database
        $kelas = Kelas::where('kelas', $row[3])->first();
        if (!$kelas) {
            //Jika kelas tidak ada, tambahkan atau buat kelas baru
            $kelas = Kelas::create([
                'kelas' => $row[3],
            ]);
        }

        //Cek apakah tahun ajaran sudah ada di database
        $tahunAjaran = Tahun_Ajaran::where('tahun_ajaran', $row[4])->first();
        if (!$tahunAjaran) {
            $tahunAjaran = Tahun_Ajaran::create([
                'tahun_ajaran' => $row[4],
            ]);
        }

        // Cek apakah siswa sudah ada berdasarkan NIS
        $siswa = Siswa::where('nis', $row[1])->first();
        if (!$siswa) {
            // Jika siswa belum terdaftar, buat siswa baru
            $siswa = Siswa::create([
                'nis' => $row[1],
                'nama' => $row[2],
                'kelas' => $kelas, // Pastikan relasi dengan kelas_id
                'tahun_ajaran_id' => $tahunAjaran->id,
            ]);
        }

        //Mengubah format tanggal dari excel sesuaikan dengan format database
        if (is_numeric($row[5])) {
            // Mengubah format tanggal dari excel sesuaikan dengan format database
            try {
                $tgl_tagihan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format('Y-m-d');
            } catch (\Exception $e) {
                // Jika terjadi error, gunakan tanggal default
                $tgl_tagihan = now()->format('Y-m-d'); // Menggunakan tanggal saat ini
            }
        } else {
            // Jika tanggal tidak valid, gunakan tanggal default
            $tgl_tagihan = now()->format('Y-m-d'); // Menggunakan tanggal saat ini
        }

        //Membuat tagihan baru
        $tagihan = new Tagihan([
            'user_id' => auth()->id(),
            'siswa_id' => $siswa->id,
            'nama' => $row[2],
            'nis' => $row[1],
            'kelas' => $row[3],
            'tahun_ajaran_id' => $tahunAjaran->id,
            'nama_tag' => 'Sumbangan Sukarela Orang Tua',
            'jumlah' => (int) $row[6],
            'tgl_tagihan' => $tgl_tagihan,
            'keterangan' => null,
            'status' => $row[7],
        ]);

        //Simpan tagihan
        $tagihan->save();

        //Simpan detail tagihan
        DetailTagihan::create([
            'tagihan_id' => $tagihan->id,
            'nama_bayar' => 'Sumbangan Sukarela Orang Tua',
            'jumlah_bayar' => (int) $row[6],
        ]);

        return $tagihan;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1' => 'Kolom NIS wajib diisi',
            '2' => 'Kolom nama wajib diisi',
            '3' => 'Kolom kelas wajib diisi',
            '4' => 'Kolom tahun ajaran wajib diisi',
            '5' => 'Kolom tanggal wajib diisi',
            '6' => 'Kolom jumlah tagihan wajib diisi',
            '7' => 'Kolom status tagihan wajib diisi',
        ];
    }
}