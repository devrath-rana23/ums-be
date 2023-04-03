<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 0;

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
        'role_id',
        'google_id',
        'avatar',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'role_id' => 'integer',
        'created_at' => 'integer',
        'updated_at' => 'integer',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public static function createUser($request, $imagePath = "")
    {
        $user = new self();
        $user->name = $request->employee_name;
        $user->role_id = $request->role_id;
        $user->avatar = $imagePath;
        $user->status = self::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();
        return $user->save();
    }
}
