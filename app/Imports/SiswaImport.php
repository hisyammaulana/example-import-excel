<?php

namespace App\Imports;

use App\KelasSiswa;
use App\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    private $id_sekolah;

    public function __construct($id_sekolah = 1)
    {
        $this->id_sekolah  = $id_sekolah;
    }

    use Importable;

    public function startRow(): int
    {
        return 13;
    }

    public function model(array $row)
    {
        $password = empty($row['nisn']) ? Str::random(8) : $row['nisn'];

        $siswa = Siswa::create([
            'nik' => empty($row['nik']) ? null : Str::of($row['nik'])->trim("'"),
            'nis' => empty($row['nis']) ? null : Str::of($row['nis'])->trim("'"),
            'nisn' => empty($row['nisn']) ? null : Str::of($row['nisn'])->trim("'"),
            'nama' => $row['nama'],
            'jenkel' => $row['jenkel'],
            'agama' => $row['agama'],
            'telepon' => $row['telepon'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tgl_lahir' => $row['tgl_lahir'],
            'first_password' => $password,
            'password' => bcrypt($password),
            'sosial' => Str::of('' . $row['nama'] . ' ' . Str::random(10) . '')->slug('-'),
            'status' => 1,
            'id_sekolah' => $this->id_sekolah,
        ]);

        $kelas_siswa = KelasSiswa::create([
            'id_siswa' => $siswa->id,
            'id_rombel' => $row['id_rombel'],
            'id_kelas' => 1,
            'id_jurusan' => 1,
            'tahun' => substr($row['tahun_ajaran'], 0, 4),
            'status' => 1,
            'id_sekolah' => $this->id_sekolah
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => 'nullable|numeric',
            'nis' => 'required|numeric|unique:siswas,nis,NULL,id,id_sekolah,' . $this->id_sekolah,
            'nisn' => 'nullable|numeric',
            'telepon' => 'nullable',
            'email' => 'nullable|email|unique:user_siswas,email',
            'nama' => 'required',
            'agama' => 'required',
            'id_rombel' => 'required',
            'tgl_lahir' => 'nullable|date'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.numeric' => 'Inputan nik berupa nomor ',
            'agama.required' => 'Agama harus diisi ',
            'id_rombel.required' => 'ID Rombel harus diisi ',
            'nis.required' => 'Nis harus diisi ',
            'nis.unique' => 'Nis sudah terdaftar ',
            'nis.numeric' => 'Inputan nis berupa nomor ',
            'nisn.required' => 'Nisn harus diisi ',
            'nisn.numeric' => 'Inputan nisn berupa nomor ',
            'email.email' => 'Inputan email tidak valid ',
            'email.unique' => 'Inputan email sudah terdaftar di database ',
            'tgl_lahir.date' => 'Inputan tanggal lahir tidak valid ',
        ];
    }
}
