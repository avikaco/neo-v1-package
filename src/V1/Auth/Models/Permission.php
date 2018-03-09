<?php
namespace Ax\Neo\V1\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    public $timestamps = false;

    protected $connection = 'neo_v1';

    protected $table = 'permission';

    protected $primaryKey = 'permission_id';

    protected $fillable = [
        'permission',
        'description',
        'print_as',
        'backoffice_display_group'
    ];

    protected $casts = [
        'permission_id' => 'integer'
    ];

    public function __construct(array $attributes = [])
    {
        $this->connection = env('DB_NEO_CONFIG', 'mysql');
        
        parent::__construct($attributes);
    }
}
