<?php
namespace Ax\Neo\V1\Auth\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'barcode',
        'magnetic_stripe'
    ];

    protected $table = 'user';

    protected $primaryKey = 'user_id';

    protected $casts = [
        'active' => 'boolean',
        'user_id' => 'integer'
    ];

    public function __construct(array $attributes = [])
    {
        $this->connection = env('DB_NEO_CONFIG', 'mysql');
        
        parent::__construct($attributes);
    }

    public function getRememberToken()
    {
        return null; // not supported
    }

    public function setRememberToken($value)
    {
        // not supported
    }

    public function getRememberTokenName()
    {
        return null; // not supported
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (! $isRememberTokenAttribute) {
            parent::setAttribute($key, $value);
        }
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
}
