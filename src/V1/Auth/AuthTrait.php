<?php
namespace Ax\Neo\V1\Auth;

// use Socialite;
use Illuminate\Support\Facades\Auth;
use Ax\Neo\V1\Models\User;

trait AuthTrait {

    protected $oAuthDrivers = [
        'google',
        'facebook'
    ];

    public function loginWithUsernamePassword($username, $password, $rememberMe = false)
    {
        if (empty($username)) {
            throw new \Exception('Username tidak boleh kosong.');
        } elseif (empty($password)) {
            throw new \Exception('Password tidak boleh kosong.');
        }
        
        $credential = [
            'user_name' => $username,
            'password' => \Hash::make($password),
            'rememberMe' => $rememberMe
        ];
        
        return $this->_login($credential);
    }

    public function loginWithPassword($password, $rememberMe = false)
    {
        if (empty($password)) {
            throw new \Exception('Password tidak boleh kosong.');
        }
        
        $credential = [
            'password' => \Hash::make($password),
            'rememberMe' => $rememberMe
        ];
        
        return $this->_login($credential);
    }

    public function loginWithFingerprint($fingerprint)
    {
        if (empty($password)) {
            throw new \Exception('Fingerprint data tidak boleh kosong.');
        }
        
        $credential = [
            'fingerprint' => \Hash::make($fingerprint)
        ];
        
        return $this->_login($credential);
    }

    public function loginWithOauth($provider)
    {
        if (in_array($provider, $this->oAuthDrivers) === false) {
            throw new \Exception('oAuth not found!');
        }
        
        return Socialite::driver($provider)->redirect();
    }

    public function loginWithOauthCallback($provider)
    {
        if (in_array($provider, $this->oAuthDrivers) === false) {
            throw new \Exception('oAuth not found!');
        }
        
        try {
            $oAuthUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            throw new \Exception('User not found!');
        }
        
        return $this->_login([
            'email' => $oAuthUser->getEmail()
        ]);
    }

    private function _login($credential)
    {
        $credential['active'] = true;
        $rememberMe = isset($credential['rememberMe']) ? ! ! $credential['rememberMe'] : false;
        unset($credential['rememberMe']);
        
        // cari di NEO user
        $user = User::where($credential)->first();
        if (! $user) {
            throw new \Exception('Login anda tidak valid!');
        }
        
        // authenticate user
        Auth::login($user, $rememberMe);
        
        return true;
    }

    public function logout()
    {
        Auth::logout();
    }
}