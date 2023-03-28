<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSkillPivot extends Model
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
        'employee_id',
        'skill_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'employee_id' => 'integer',
        'skill_id' => 'integer',
    ];

    public static function createEmployeeSkills($request)
    {
        $skills = explode(',', $request->skills);
        foreach ($skills as $key => $value) {
            $empSkill = new self();
            $empSkill->employee_id = $request->employee_id;
            $empSkill->skill_id = (int)$value;
            $empSkill->save();
        }
    }
}
