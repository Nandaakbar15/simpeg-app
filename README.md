# Simpeg - Sistem Kepegawaian ASN

Aplikasi kepegawaian ASN berbasis web untuk mengelola data pegawai, riwayat keluarga, dan administrasi internal secara terstruktur dan efisien.

## Main Feature

Fitur-Fitur yang sudah ada :

- superadmin : CRUD User Admin, User Pegawai, CRUD Data Pegawai, CRUD Riwayat Keluarga Anak dan Suami / Istri, CRUD Hukuman, CRUD Diklat dll

- admin : CRUD User Pegawai, CRUD Data Pegawai, CRUD Riwayat Keluarga Anak dan Suami

- pegawai : Melihat profil, riwayat pendidikan, prestasi kerja, dll.

## Tech Stack

- Laravel
- MySQL
- Tailwind CSS

## Requirements

- PHP >= 8.x
- Composer
- Node.js & npm
- MySQL

## Cara Install

### Clone repository

Clone repository dengan memasukan perintah git clone https://github.com/Nandaakbar15/simpeg-app.git

### Install Laravel dependencies

Install Laravel dependencies dengan memasukan perintah composer install

### Install vite depencies

Install vite depencies karena project ini menggunakan plugin vite + tailwind css dengan jalankan perintah npm install

- Note:
  Jika ada warning npm audit, masukan perintah npm audit fix

### Konfigurasi .env config file

Setelah install beberapa dependencies-nya, copy file .env dengan jalankan perintah cp .env.example .env.

Jika sudah maka generate key dengan jalankan perintah php artisan key:generate

### Migrate the tables

Untuk migration databasenya, pertama buat database baru terlebih dahulu lewat phpmyadmin. Setelah itu ubah nama databasenya sesuai yang di .env
Setelah itu, masukan perintah `php artisan migrate`

Dengan begitu, database akan dibuatkan secara otomatis.

### Konfigurasi Storage (Penting)

Aplikasi ini memiliki fitur unggah file. Agar file atau gambar yang diunggah dapat tersimpan dan diakses dengan benar, Anda wajib menghubungkan folder storage ke folder public.

**Langkah-langkah:**

1. Cek folder `public`. Jika sudah ada folder bernama `storage` (berupa shortcut/symlink), hapus folder tersebut terlebih dahulu.
2. Jalankan perintah berikut di terminal/command prompt:
    ```bash
    php artisan storage:link
    ```

### Menjalankan project

Untuk menjalankan projectnya masukan perintah composer run dev

### Screenshot website atau aplikasi

- Halaman Login
  ![Halaman Login](./public/images/Screenshot/Halaman%20Login.png)

<br>

- Halaman Dashboard untuk superadmin dan admin
  ![Halaman Dashboard](./public/images/Screenshot/Halaman%20Dashboard%20untuk%20superadmin%20dan%20admin.png)

<br>

- Halaman Instansi Lembaga
  ![Halaman Instansi Lembaga](./public/images/Screenshot/Halaman%20Instansi%20Lembaga.png)

<br>

- Halaman Sekretariat
  ![Halaman Sekretariat](./public/images/Screenshot/Halaman%20Sekretariat.png)

<br>

- Halaman Data User Admin
  ![Halaman Data User Admin](./public/images/Screenshot/Halaman%20Data%20User%20Admin.png)

<br>

- Halaman Data User Pegawai
  ![Halaman Data User Pegawai](./public/images/Screenshot/Halaman%20Data%20User%20Pegawai.png)

<br>

- Halaman Data Pegawai
  ![Halaman Data Pegawai](./public/images/Screenshot/Halaman%20Data%20Pegawai.png)

<br>

- Halaman Riwayat Pendidikan
  ![Halaman Data Riwayat Pendidikan](./public/images/Screenshot/Halaman%20Data%20Riwayat%20Pendidikan%20Sekolah.png)

<br>

- Halaman Data TPP
  ![Halaman Data TPP](./public/images/Screenshot/Halaman%20Data%20TPP.png)

<br>

- Halaman Data Rekapitulasi Jabatan
  ![Halaman Data Rekapitulasi Jabatan](./public/images/Screenshot/Halaman%20Data%20Rekapitulasi%20Jabatan.png)

<br>

- Halaman Report Nominatif
  ![Halaman Report Nominatif](./public/images/Screenshot/Halaman%20Report%20Nominatif.png)

<br>

- Halaman Backup Database
  ![Halaman Backup Database](./public/images/Screenshot/Halaman%20Backup%20Database.png)
