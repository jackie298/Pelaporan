<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Agar bisa baca nama kolom di Excel

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name'     => $row['nama'],  // 'nama' adalah judul kolom di file Excel
            'email'    => $row['email'],
            'password' => bcrypt($row['password']),
        ]);
    }
}