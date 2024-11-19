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
    // Skip jika baris kosong
    if (!array_filter($row)) {
        return null;
    }

    // Ambil tahun ajaran dari kolom ke-6
    $tahunAjaran = Tahun_Ajaran::where('tahun_ajaran', $row[5])->first();

        if (!$tahunAjaran) {
            // Jika tidak ada, tambahkan tahun ajaran baru ke database
            $tahunAjaran = Tahun_Ajaran::create([
                'tahun_ajaran' => $row[5],
            ]);
        }

    // Cek apakah kelas sudah ada di database
    $kelas = Kelas::where('kelas', $row[4])->first();
    if (!$kelas) {
        // Jika tidak ada, tambahkan kelas baru ke database
        $kelas = Kelas::create([
            'kelas' => $row[4],
        ]);
    }

    // Ambil NIS dari kolom
    $nis = $row[2];

    // Jika NIS adalah '-', atur NIS menjadi 'NIS_TIDAK_TERSEDIA'
    if ($nis === '-') {
        $nis = 'NIS_TIDAK_TERSEDIA';
        
        // Cek apakah NIS_TIDAK_TERSEDIA sudah ada
        $existingSiswa = Siswa::where('nis', $nis)->first();
        if ($existingSiswa) {
            // Jika sudah ada, bisa mengabaikan baris ini atau memperbarui data yang ada
            return null; // Mengabaikan baris ini
        }
    } else {
        // Jika NIS terisi, periksa apakah sudah ada di database
        $existingSiswa = Siswa::where('nis', $nis)->first();
        if ($existingSiswa) {
            // Jika NIS sudah ada, bisa mengabaikan baris ini atau memberikan pesan kesalahan
            return null; // Mengabaikan baris ini
        }
    }

    // Buat siswa baru
    $siswa = Siswa::create([
        'nis' => $nis, // Simpan NIS yang valid atau string khusus
        'nama' => $row[3],
        'kelas' => $kelas->kelas,
        'tahun_ajaran_id' => $tahunAjaran->id,
    ]);

    // Ambil tanggal dari kolom ke-7 dan ubah formatnya
    $tgl_tagihan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('Y-m-d');

    // Membuat tagihan baru
    $tagihan = new Tagihan([
        'user_id' => auth()->id(),
        'siswa_id' => $siswa->id,
        'nama' => $row[3],
        'nis' => $nis, // Gunakan NIS yang sudah ditentukan
        'kelas' => $kelas->kelas,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'nama_tag' => 'Sumbangan Sukarela Orang Tua',
        'jumlah' => (int) $row[7],
        'tgl_tagihan' => $tgl_tagihan,
        'keterangan' => null,
        'status' => $row[8],
    ]);

    // Simpan tagihan
    $tagihan->save();

    // Simpan detail tagihan
    DetailTagihan::create([
        'tagihan_id' => $tagihan->id,
        'nama_bayar' => 'Sumbangan Sukarela Orang Tua',
        'jumlah_bayar' => (int) $row[7],
    ]);

    return $tagihan;
}

public function startRow(): int
{
    return 3; // Data dimulai dari baris ke-3
}

public function rules(): array
{
    return [
        '2' => 'required', // NIS tidak boleh kosong dan harus berupa string
        '3' => 'required', // Nama siswa wajib diisi
        '4' => 'required', // Kelas wajib diisi
        '5' => 'required', // Tahun ajaran wajib diisi
        '6' => 'required', // Tanggal wajib diisi dan harus berupa tanggal
        '7' => 'required|integer', // Jumlah sumbangan wajib diisi dan berupa angka
        '8' => 'required|in:Baru,Mengangsur,Lunas', // Status hanya boleh salah satu dari 3 pilihan
    ];
}

public function customValidationMessages()
{
    return [
        '2.required' => 'Kolom NIS wajib diisi dan tidak boleh null.',
        '3' => 'Kolom Nama Lengkap Siswa wajib diisi.',
        '4' => 'Kolom Kelas wajib diisi.',
        '5' => 'Kolom Tahun Ajaran wajib diisi.',
        '6' => 'Kolom Tanggal wajib diisi dan harus berupa tanggal.',
        '7' => 'Kolom Jumlah Sumbangan wajib diisi dan harus berupa angka.',
        '8' => 'Kolom Status wajib diisi dengan salah satu dari: Baru, Mengangsur, Lunas.',
    ];
}
}