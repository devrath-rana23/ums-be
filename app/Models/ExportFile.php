<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportFile extends Model
{
    use HasFactory;

    public $table = "export_files";

    const USERS_ENTITY = 1;
    const ROLES_ENTITY = 2;
    const SKILLS_ENTITY = 3;

    const ENTITY_NAME = [
        self::USERS_ENTITY => "Users",
        self::ROLES_ENTITY => "Roles",
        self::SKILLS_ENTITY => "Skills",
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'entity_type',
        'user_id',
        'created_at',
        'updated_at',
        'filename',
        'filepath',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'entity_type' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'integer',
        'updated_at' => 'integer',
        'filename' => 'string',
        'filepath' => 'string',
    ];

    public static function createExportFile($request)
    {
        self::insert($request);
    }
}
