# Simpeg - Sistem Kepegawaian ASN

Aplikasi kepegawaian ASN berbasis web untuk mengelola data pegawai, riwayat keluarga, dan administrasi internal secara terstruktur dan efisien.

## Main Feature

Fitur-Fitur yang sudah ada :

- superadmin : CRUD User Admin, User Pegawai, CRUD Data Pegawai, CRUD Riwayat Keluarga Anak dan Suami / Istri

- admin : CRUD User Pegawai, CRUD Data Pegawai, CRUD Riwayat Keluarga Anak dan Suami

Fitur-Fitur yang belum ada :

- CRUD Jabatan
- CRUD Pangkat
- CRUD Hukuman
- CRUD Diklat
- CRUD Penghargaan
- CRUD Penugasan LN
- CRUD Seminar
- CRUD Cuti
- CRUD Latihan Jabatan
- CRUD Mutasi
- CRUD Tunjangan
- CRUD Izin Kawin

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

### Menjalankan project

Untuk menjalankan projectnya masukan perintah composer run dev
