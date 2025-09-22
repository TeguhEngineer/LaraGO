<?php

namespace App\Imports;

use App\Models\ContactTemp;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsTempImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:8,15',
        ]);

        $errors = $validator->fails() ? $validator->errors()->all() : [];

        return new ContactTemp([
            'name' => $row['name'] ?? null,
            'phone' => $row['phone'] ?? null,
            'is_valid' => empty($errors),
            'error_messages' => json_encode($errors),
        ]);
    }
}