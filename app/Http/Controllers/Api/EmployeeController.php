<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Employee as EmployeeRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeRequest  $request
     * @return JsonResponse
     */
    public function store(EmployeeRequest $request): JsonResponse
    {
        return $this->service->store($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        return $this->service->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $rules = [
            'name' => 'required|max:255',
            'role_id' => 'required|numeric',
            'birth' => 'required',
            'salary' => 'required|numeric',
            'martial_status' => 'required|in:single,married,divorced',
            'bonus' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        $errors = $validator->errors()->toArray();
        $errorMessage = "";
        foreach ($errors as $key => $value) {
            $errorMessage = isset($value[0]) && !empty($value[0]) ? $value[0] : "";
            break;
        }
        if ($validator->fails()) {
            return response()->json([
                'message' => $errorMessage,
                'data' => [],
                'errors'      =>  $errors,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
        return $this->service->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->service->destroy($id);
    }
}
