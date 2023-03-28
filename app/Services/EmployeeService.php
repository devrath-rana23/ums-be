<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\ContactInfo;
use App\Models\Employee;
use App\Models\EmployeeSkillPivot;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Employee as EmployeeRequest;

/**
 * Class EmployeeService handles the employees actions.
 **/

class EmployeeService
{


    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {
            $data = User::with('role')->with('employee')->get();
            foreach ($data as  $value) {
                $value->employee->contactInfo;
                $value->employee->skills;
            }
            return response()->json([
                'data' => $data,
                'message' => trans('messages.employees_fetched_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Employee List:', $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeRequest  $request
     */

    public function store($request)
    {
        try {
            DB::transaction(function () use ($request) {
                User::createUser($request);
                $request->request->add(['user_id' => User::orderBy('id', 'desc')->first()->id]);
                Employee::createEmployee($request);
                $request->request->add(['employee_id' => Employee::orderBy('id', 'desc')->first()->id]);
                ContactInfo::createContactInfo($request);
                EmployeeSkillPivot::createEmployeeSkills($request);
            });
            return response()->json([
                'data' => [],
                'message' => trans('messages.employee_created_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Employee List:', $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update($request, $id)
    {
        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        return response()->json([]);
    }
}
