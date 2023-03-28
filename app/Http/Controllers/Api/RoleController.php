<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $queryString = request()->query();
            if (Redis::get('roles.list')) {
                return response()->json([
                    'data' => json_decode(Redis::get('roles.list')),
                    'message' => trans('messages.role_fetched_successfully'),
                    'exception_message' => '',
                    'status' => Response::HTTP_OK
                ]);
            }
            $data = Role::paginate(10);
            Redis::set('roles.list', json_encode($data));
            return response()->json([
                'data' => $data,
                'message' => trans('messages.roles_fetched_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Role List:' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            Role::createRole($request);
            if (Redis::get('roles.list')) {
                Redis::del(('roles.list'));
            }
            return response()->json([
                'data' => [],
                'message' => trans('messages.role_created_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Role Create:' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        try {
            $data = Role::find($id);
            return response()->json([
                'data' => $data,
                'message' => trans('messages.role_fetched_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Role Edit:' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
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
        try {
            Role::updateRole($request, $id);
            if (Redis::get('roles.list')) {
                Redis::del(('roles.list'));
            }
            return response()->json([
                'data' => [],
                'message' => trans('messages.role_updated_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Role Update:' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            Role::destroy($id);
            if (Redis::get('roles.list')) {
                Redis::del(('roles.list'));
            }
            return response()->json([
                'data' => [],
                'message' => trans('messages.role_deleted_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Role Delete:' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }
}
