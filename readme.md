# NEO Package #

## Installation ##

1. Tambahkan di `composer.json`
```json
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/avikaco/neo-v1-package.git"
    },
]
```
2. Install via composer **ax/neo**, `composer require ax/neo`,
3. Jika menggunakan multiple database setting, lihat bagian setting DB dibagian bawah.
4. Cek app config di `config/app.php` bagian providers, comment baris ini `Illuminate\Hashing\HashServiceProvider::class`, 
5. Masih di app config bagian providers, seharusnya ada `"Ax\\Neo\\AxNeoServiceProvider",` dan `"Ax\\Neo\\V1\\Auth\\HasherProvider",` . Jika belum ada silahkan ditambahkan manual.
6. Buka terminal untuk melakukan test apakah package sudah terinstall dengan benar. Jalankan perintah `php artisan neo:check`


## Jika NEO dan App Berbeda Database ##

Contoh nama koneksi untuk NEO adalah **neo**.
1. Di file `config/database.php` dibagian `connections`, tambahkan:
```php
'neo' => [
    'driver' => 'mysql',
    'host' => env('DB_NEO_HOST', '127.0.0.1'),
    'port' => env('DB_NEO_PORT', '3306'),
    'database' => env('DB_NEO_DATABASE', 'forge'),
    'username' => env('DB_NEO_USERNAME', 'forge'),
    'password' => env('DB_NEO_PASSWORD', ''),
    'unix_socket' => env('DB_NEO_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'strict' => true,
    'engine' => null,
],
```
2. Di file `.env` tambahkan setting berikut:
```bash
DB_NEO_CONFIG=neo
DB_NEO_HOST=127.0.0.1
DB_NEO_PORT=3306
DB_NEO_DATABASE=homestead
DB_NEO_USERNAME=homestead
DB_NEO_PASSWORD=secret
```
