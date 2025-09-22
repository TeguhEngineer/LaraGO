<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ContactsImport implements ToModel, ToCollection, WithHeadingRow, WithChunkReading, WithValidation
{
    // use SkipsFailures;

    public $rows = []; // simpan semua data untuk validasi global

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $this->rows[] = [
                'row'   => $index + 2, // +2 karena heading di row 1
                'name'  => $row['name'] ?? null,
                'phone' => $row['phone'] ?? null,
            ];
        }
    }

    public function model(array $row)
    {
        // Simpan ke array untuk validasi global nanti
        $this->rows[] = $row;

        return new Contact([
            'name'  => $row['name'] ?? null,
            'phone' => $row['phone'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required', 'string', 'max:255'],
            '*.phone' => [
                'required',
                'numeric',
                'digits_between:10,15',
                Rule::unique('contacts', 'phone'),
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.name.required' => 'Nama tidak boleh kosong.',
            '*.phone.required' => 'Nomor telepon wajib diisi.',
            '*.phone.numeric' => 'Nomor telepon harus berupa angka.',
            '*.phone.digits_between' => 'Nomor telepon minimal 10 digit dan maksimal 15 digit.',
            '*.phone.unique' => 'Nomor telepon ini sudah terdaftar.',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
