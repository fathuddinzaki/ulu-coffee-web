# Ulu Coffee - Versi Legacy PHP & MySQL

Folder ini berisi versi awal website Ulu Coffee yang dikembangkan menggunakan PHP native dan MySQL.

## Struktur Folder
- `admin/` : Dashboard admin, kasir POS, dan manajemen pesanan PHP.
- `api/` : Endpoint integrasi payment Midtrans.
- `includes/` : Konfigurasi database (`db.php`), helper (`functions.php`), template header & footer.
- `assets/` : Gambar, CSS, dan file statis untuk PHP.
- `database.sql` : Skema dan data awal database MySQL.

## Cara Menjalankan Versi PHP di XAMPP
1. Pastikan Apache & MySQL aktif di XAMPP.
2. Buat database `ulu_coffee` di phpMyAdmin (`http://localhost/phpmyadmin`) dan import `database.sql`.
3. Akses via browser: `http://localhost/ulu-coffee-web/legacy-php/`

