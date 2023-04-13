<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Skill as SkillRequest;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = Skill::paginate(10);
            return response()->json([
                'data' => $data,
                'message' => trans('messages.skills_fetched_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Skill List: ' . $ex);
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
     * @param  SkillRequest  $request
     * @return JsonResponse
     */
    public function store(SkillRequest $request): JsonResponse
    {
        try {
            Skill::createSkill($request);
            return response()->json([
                'data' => [],
                'message' => trans('messages.skill_created_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Skill Create: ' . $ex);
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
    public function show($id): JsonResponse
    {
        try {
            $data = Skill::find($id);
            return response()->json([
                'data' => $data,
                'message' => trans('messages.skill_fetched_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Skill Edit:' . $ex);
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
            Skill::updateSkill($request, $id);
            return response()->json([
                'data' => [],
                'message' => trans('messages.skill_updated_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Skill Update:' . $ex);
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
            Skill::destroy($id);
            return response()->json([
                'data' => [],
                'message' => trans('messages.skill_deleted_successfully'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Skill Delete:' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }
}
