<?php
namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

class BackofficeModule extends Model
{

    protected $table = 'bo_module';

    protected $primaryKey = 'module_id';

    protected $fillable = [
        'module_name',
        'module_url',
        'type'
    ];

    protected $connection = 'neo_v1';

    public $timestamps = false;

    protected $casts = [
        'module_id' => 'integer'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'bo_role_module', 'role_id', 'module_id');
    }
}
