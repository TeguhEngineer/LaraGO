<?php

namespace App\Imports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Contact([
            'name'  => $row[0] ?? null,
            'phone' => $row[1] ?? null,  // kolom header “phone”
        ]);
    }
     public function uniqueBy()
    {
        return 'phone';  // misalnya berdasarkan nomor telepon
    }

    /**
     * Validasi untuk baris - baris Excel
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:50',  
            // bisa tambahkan rule lain seperti unik, numeric, dll
        ];
    }
}
