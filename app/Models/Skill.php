<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
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

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public static function createSkill($request)
    {
        $skill = new self();
        $skill->name = $request->name;
        $skill->created_at = time();
        $skill->updated_at = time();
        $skill->save();
    }

    public static function updateSkill($request, $id)
    {
        $skill = self::find($id);
        $skill->name = $request->name;
        $skill->updated_at = time();
        $skill->save();
    }
}
