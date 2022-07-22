## PROJECT SEMESTER (On Progress)
 - Halaman Admin Progress `80%`
 - Halaman Pengguna Progress `70%`

## Cara Installasi
 - Pastikan GIT sudah terinstall dan siap pakai.
 - Clone repository ini dengan link `https://github.com/nuzulr24/meubelv2`
 - Buka CMD atau Terminal dan pastikan sudah terinstall composer
 - Ketik `composer install` dan tekan Enter.
 - Silahkan buat file `.env` dan ubah dengan database serta lakukan di cmd ketik dengan `php artisan key:generate` lalu `php artisan config:cache`.
 - Ketika `php artisan storage:link` agar file public dapat diakses.
 - Test website dengan ketik di cmd `php artisan serve`.

## Database
`Pastikan Database Sudah Di Update Sesuai Yang Ada Di Repository` dengan import database yang ada pada folder file sql

## Halaman Admin
url: 127.0.0.1:8000/admin
email: miqbal.admin@email.com
pass: admin123