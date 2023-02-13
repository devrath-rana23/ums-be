<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
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
        'phone',
        'email',
        'employee_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'created_at' => 'integer',
        'updated_at' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public static function createContactInfo($request)
    {
        $contact = new self();
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->employee_id = $request->employee_id;
        $contact->created_at = time();
        $contact->updated_at = time();
        return $contact->save();
    }
}
