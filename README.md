# Full Stack Web Development - Chapter 4

## Portal Pelajar MVC

Bahan amali ini dibangunkan untuk kursus **Full Stack Web Development**, Chapter 4, bersama pelajar **Politeknik Kuala Terengganu** bagi sesi **1 2026/2027**.

Projek ini menunjukkan cara membina aplikasi web PHP menggunakan konsep **Model-View-Controller (MVC)**. Aplikasi yang dibangunkan ialah portal pelajar ringkas untuk pendaftaran pengguna, log masuk, pengurusan rekod pengguna dan pendaftaran markah.

## Objektif Pembelajaran

Selepas melengkapkan projek ini, pelajar dapat:

- menerangkan konsep asas seni bina MVC;
- mengasingkan kod kepada Controller, Model dan View;
- membina routing menggunakan parameter URL;
- menyambungkan aplikasi PHP kepada pangkalan data MySQL;
- melaksanakan operasi CRUD asas;
- menggunakan session untuk kawalan log masuk;
- menggunakan `password_hash()` dan `password_verify()` untuk kata laluan;
- memproses borang dan muat naik gambar;
- menggunakan Composer autoloading berasaskan PSR-4.

## Teknologi Digunakan

- PHP 8 atau lebih baharu
- MySQL / MariaDB
- Apache melalui Laragon
- Composer
- HTML, CSS dan Bootstrap
- MySQLi
- PHP Sessions

## Keperluan Sistem

Pastikan perisian berikut telah dipasang:

1. [Laragon](https://laragon.org/)
2. PHP 8 atau lebih baharu
3. MySQL atau MariaDB
4. Composer
5. Pelayar web seperti Chrome, Edge atau Firefox

## Cara Menjalankan Projek

### 1. Letakkan projek dalam Laragon

Salin folder projek ke:

```text
C:\laragon\www\fs-mvc
```

Lokasi sebenar mungkin berbeza mengikut pemasangan Laragon. Dalam persekitaran ini, projek berada di:

```text
d:\laragon\www\fs-mvc
```

### 2. Hidupkan servis Laragon

Buka Laragon dan hidupkan:

- Apache
- MySQL

### 3. Sediakan pangkalan data

Buka HeidiSQL, phpMyAdmin atau terminal MySQL, kemudian cipta pangkalan data:

```sql
CREATE DATABASE student_portal_db;
USE student_portal_db;
```

Cipta jadual pengguna:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    nric VARCHAR(12) NOT NULL UNIQUE,
    program VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'student',
    profile_picture VARCHAR(255) DEFAULT NULL
);
```

Cipta jadual markah:

```sql
CREATE TABLE marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nric VARCHAR(12) NOT NULL,
    subjek VARCHAR(100) NOT NULL,
    markah VARCHAR(10) NOT NULL
);
```

Fail sambungan pangkalan data menggunakan tetapan lalai berikut:

```text
Host     : localhost
Username : root
Password : kosong
Database : student_portal_db
```

Tetapan tersebut boleh diubah dalam `app/includes/db_connect.php` mengikut konfigurasi komputer masing-masing.

### 4. Pasang Composer autoloading

Dari folder projek, jalankan:

```bash
composer install
```

Jika folder `vendor` telah tersedia, langkah ini mungkin tidak diperlukan. Jalankan arahan berikut sekiranya perlu menjana semula autoloader:

```bash
composer dump-autoload
```

### 5. Akses aplikasi

Buka URL berikut pada pelayar:

```text
http://localhost/fs-mvc/
```

## Fungsi Aplikasi

### Pengguna biasa

- mendaftar akaun baharu;
- log masuk menggunakan nombor IC dan kata laluan;
- melihat dashboard dan senarai pengguna;
- log keluar daripada sistem.

### Admin

Admin boleh melaksanakan fungsi tambahan berikut:

- melihat semua rekod pengguna;
- mengemaskini maklumat pengguna;
- memadam rekod pengguna;
- memuat naik gambar profil;
- mendaftarkan markah bagi seseorang pelajar.

Untuk menjadikan akaun sebagai admin, ubah nilai `role` dalam jadual `users`:

```sql
UPDATE users
SET role = 'admin'
WHERE nric = 'NOMBOR_IC_PENGGUNA';
```

## Laluan Aplikasi

Aplikasi menggunakan satu fail kemasukan utama, iaitu `index.php`. Fungsi ditentukan melalui parameter `action`.

| Fungsi | URL |
|---|---|
| Halaman utama | `index.php` |
| Log masuk | `index.php?action=login` |
| Pendaftaran | `index.php?action=register` |
| Dashboard | `index.php?action=dashboard` |
| Log keluar | `index.php?action=logout` |
| Kemaskini pengguna | `index.php?action=edit&id=ID` |
| Padam pengguna | `index.php?action=delete` |
| Daftar markah | `index.php?action=daftarMarkah&id=ID` |

## Struktur Projek

```text
fs-mvc/
├── app/
│   ├── controllers/
│   │   └── MainController.php
│   ├── includes/
│   │   └── db_connect.php
│   ├── models/
│   │   └── StudentModel.php
│   └── views/
│       ├── daftarMarkah.php
│       ├── dashboard.php
│       ├── edit_user.php
│       ├── footer.php
│       ├── header.php
│       ├── home.php
│       ├── login.php
│       └── register.php
├── uploads/
├── composer.json
├── index.php
└── README.md
```

### Penerangan komponen

- `index.php` ialah entry point dan router utama aplikasi.
- `MainController.php` menerima permintaan pengguna dan menentukan view yang perlu dipaparkan.
- `StudentModel.php` mengandungi operasi berkaitan data pengguna dan markah.
- Folder `views/` mengandungi paparan HTML dan borang aplikasi.
- `db_connect.php` menyediakan sambungan kepada MySQL.
- Folder `uploads/` menyimpan gambar profil yang dimuat naik.
- `composer.json` menetapkan autoloading namespace `App\` kepada folder `app/`.

## Aliran MVC Ringkas

```text
Permintaan pengguna
        |
        v
    index.php
        |
        v
 MainController
        |
        +--> StudentModel --> MySQL
        |
        v
      View
```

Contoh aliran log masuk:

1. Pengguna membuka `index.php?action=login`.
2. `index.php` memanggil method `login()` dalam `MainController`.
3. Controller menerima data borang.
4. Controller meminta `StudentModel` menyemak pengguna dalam pangkalan data.
5. Jika berjaya, session pengguna diwujudkan.
6. Pengguna diarahkan ke dashboard.


## Pengarang Dan Konteks Pengajaran

Bahan ini disediakan sebagai contoh projek amali untuk:

- **Kursus:** Full Stack Web Development
- **Chapter:** 4 - MVC dan Pengurusan Data Web
- **Institusi:** Politeknik Kuala Terengganu
- **Sesi:** 1 2026/2027
