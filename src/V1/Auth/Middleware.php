<?php
namespace Ax\Neo\V1\Auth;

use Closure;
use Hash;
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
        
        return $this->auth->guard($guard)->basic('user_name', $extraConditions) ?: $next($request);
    }
}