<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User;
        $user->id = 1;
        $user->name = 'Devrath Singh Rana';
        $user->role_id = 1;
        $user->created_at = time();
        $user->updated_at = time();
        $user->save();

        $employee = new \App\Models\Employee;
        $employee->id = 1;
        $employee->salary = 25000;
        $employee->user_id = 1;
        $employee->created_at = time();
        $employee->updated_at = time();
        $employee->save();

        $contact = new \App\Models\ContactInfo;
        $contact->id = 1;
        $contact->phone = 9871020895;
        $contact->email = 'devrath.rana98@gmail.com';
        $contact->employee_id = 1;
        $contact->created_at = time();
        $contact->updated_at = time();
        $contact->save();
    }
}
