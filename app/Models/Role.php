<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

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
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'created_at' => 'integer',
        'updated_at' => 'integer',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function createRole($request)
    {
        $role = new self();
        $role->name = $request->name;
        $role->created_at = time();
        $role->updated_at = time();
        $role->save();
    }

    public static function updateRole($request, $id)
    {
        $role = self::find($id);
        $role->name = $request->name;
        $role->updated_at = time();
        $role->save();
    }
}
