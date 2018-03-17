# NEO Package #

Ini adalah package Laravel yang dibuat untuk mempermudah koneksi dengan NEO.

## Installation ##

1. Tambahkan custom repository pada composer, diterminal ketik `composer config repositories.ax git https://github.com/avikaco/neo-v1-package.git`
2. Install via composer **ax/neo**, diterminal ketik `composer require ax/neo:master`
3. Cek app config di `config/app.php` bagian providers, comment baris ini `// Illuminate\Hashing\HashServiceProvider::class`
4. Jika menggunakan multiple database setting, lihat bagian [setting DB](#jika-neo-dan-app-berbeda-database) dibagian bawah.
5. Buka terminal untuk melakukan test apakah package sudah terinstall dengan benar. Jalankan perintah `php artisan neo:check`


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

## Menggunakan NEO Hash Password 

Karena kita sudah meng-overwrite Hash di Laravel dengan NEO, maka cara meng-encrypt password sama seperti native Laravel.
`\Hash::make('String Password');`


## Menggunakan Neo Auth

1. Import Auth Trait (`Ax\Neo\V1\Auth\AuthTrait`)
2. Use trait in your controller

Sample Code
```php
// use other ...
use Ax\Neo\V1\Auth\AuthTrait;

class TestController extends Controller
{
    use AuthTrait;

    public function index(Request $request)
    {
        // login with biometrik/fingerprint
        $fingerprint = $request->get('fingerprint');
        $this->loginWithFingerprint($fingerprint);
        
        // redirect to Facebook/Google oAuth
        $this->loginWithOauth('facebook');
        
        $username = $request->get('username');
        $password = $request->get('password');
        $rememberMe = true;
        
        // login with username & password
        $this->loginWithUsernamePassword($username, $password, $rememberMe);
        
        // login with password only
        $this->loginWithPassword($password, $rememberMe);
        
        // logout
        $this->logout();
        
        // check is logged in (Laravel builtin)
        if (Auth::check()) {
            // get user (Laravel builtin)
            $user = \Auth::user();
            
            // get user role
            $role = \Auth::user()->role;
            
            // get permissions
            $permissions = \Auth::user()->role->permissions;
        }
    }
}
```
  
## Setting Google & Facebook Oauth

### Google

1. Daftar ke [Google Console](https://console.developers.google.com) untuk mendapatkan API.
2. Set **Authorized redirect URIs** to `http://yourdomain/yourpath/oauth/google-callback`, jangan lupa untuk mengganti `yourdomain` & `yourpath`.
3. Tambahkan credential to `.env`

```bash
AX_OAUTH_GOOGLE_CLIENT_ID=your_client_id
AX_OAUTH_GOOGLE_CLIENT_SECRET=your_client_secret
```

### Facebook

1. Daftar ke [Facebook Developer](https://developers.facebook.com/) untuk mendapatkan API.
2. Set **Valid OAuth redirect URIs** to `http://yourdomain/yourpath/oauth/facebook-callback`, jangan lupa untuk mengganti `yourdomain` & `yourpath`.
3. Tambahkan credential to `.env`

```bash
AX_OAUTH_FACEBOOK_APP_ID=your_app_id
AX_OAUTH_FACEBOOK_APP_SECRET=your_app_secret
```