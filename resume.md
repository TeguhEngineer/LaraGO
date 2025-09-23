# Rangkuman Proyek GOWA

Proyek ini adalah aplikasi web yang dibangun menggunakan framework Laravel. Berdasarkan analisis struktur file dan kode, berikut adalah rangkuman fungsionalitas dan teknologi yang digunakan:

## Teknologi

*   **Backend**: Laravel
*   **Frontend**: Blade, Tailwind CSS, Vite
*   **Database**: Migrations menunjukkan penggunaan database relasional untuk menyimpan data pengguna, kontak, pengingat, dan lainnya.

## Fitur Utama

*   **Autentikasi Pengguna**:
    *   Registrasi, login, dan logout.
    *   Reset kata sandi dan verifikasi email.
    *   Verifikasi dua langkah menggunakan OTP (*One-Time Password*).

*   **Manajemen Kontak**:
    *   Menambah, melihat, mengedit, dan menghapus kontak.
    *   Fitur impor kontak dari file, yang kemungkinan menggunakan antrian untuk memproses file besar.

*   **Pengiriman Pesan**:
    *   Mengirim pesan, kemungkinan besar melalui WhatsApp, yang ditangani oleh `WhatsappService`.
    *   Terdapat *webhook* yang mungkin digunakan untuk menerima status pengiriman pesan atau balasan dari WhatsApp.

*   **Pengingat**:
    *   Membuat dan mengelola pengingat.
    *   Terdapat *command* `SendReminders` yang dijadwalkan untuk mengirim pengingat secara otomatis.

*   **Profil Pengguna**:
    *   Pengguna dapat memperbarui informasi profil dan kata sandi mereka.
