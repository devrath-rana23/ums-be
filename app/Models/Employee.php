<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
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
        'birth',
        'user_id',
        'salary',
        'martial_status',
        'bonus',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'birth' => 'datetime',
        'user_id' => 'integer',
        'created_at' => 'integer',
        'updated_at' => 'integer',
        'salary' => 'integer',
        'bonus' => 'decimal:2',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function contactInfo()
    {
        return $this->hasOne(ContactInfo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createEmployee($request)
    {
        $employee = new \App\Models\Employee;
        $employee->birth = $request->birth;
        $employee->salary = $request->salary;
        $employee->martial_status = $request->martial_status;
        $employee->bonus = $request->bonus;
        $employee->user_id = $request->user_id;
        $employee->created_at = time();
        $employee->updated_at = time();
        return $employee->save();
    }

    public static function updateEmployee($request)
    {
        $updateData = [
            "birth" => $request->birth,
            "salary" => $request->salary,
            "martial_status" => $request->martial_status,
            "bonus" => $request->bonus,
            "updated_at" => time(),
        ];
        $employee = self::where('user_id', $request->user_id);
        $employee->update($updateData);
        return $employee;
    }
}
