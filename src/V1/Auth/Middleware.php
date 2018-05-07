<?php
namespace Ax\Neo\V1\Auth;

use Closure;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class Middleware
{

    protected $shouldUseGuard = 'web';

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
        $this->auth->shouldUse($this->shouldUseGuard);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request            
     * @param \Closure $next            
     * @param string|null $guard            
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $extraConditions = [
            'active' => 1
        ];
        
        $allowNext = $this->auth->guard($guard)->basic('user_name', $extraConditions);
        if ($allowNext === null && $this->auth->guard($guard)->id()) {
            $allowedRoles = config('neo.auth.allowedRoles');
            if (empty($allowedRoles) === false) {
                // jika $allowedRoles kosong, maka semua user yang loginnya benar boleh akses
                // tapi jika tidak kosong (set NEO_AUTH_ROLES di .env),
                // maka hanya boleh di akses sesuai yang diset
                if (in_array($this->auth->guard($guard)->user()->role_id, $allowedRoles) === false) {
                    return abort(403, 'Anda tidak boleh mengakses aplikasi ini');
                }
            }
        }
        
        return $allowNext ?: $next($request);
    }
}