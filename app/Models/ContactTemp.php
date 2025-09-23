<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTemp extends Model
{
    protected $table = 'contacts_temp'; // Pastikan nama tabel benar
    protected $fillable = [
        'name',
        'phone',
        'is_valid',
        'error_messages',
    ];
}