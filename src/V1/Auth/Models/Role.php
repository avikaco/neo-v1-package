<?php
namespace Ax\Neo\V1\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = 'role';

    protected $primaryKey = 'role_id';

    protected $casts = [
        'active' => 'boolean'
    ];

    public function __construct(array $attributes = [])
    {
        $this->connection = env('DB_NEO_CONFIG', 'mysql');
        
        parent::__construct($attributes);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    public function backofficeModules()
    {
        return $this->belongsToMany(BackofficeModule::class, 'bo_role_module', 'role_id', 'module_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')->withPivot('outlet_id');
    }
}
