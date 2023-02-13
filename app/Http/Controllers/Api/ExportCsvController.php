<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ExportSkillsCsvJob;
use App\Models\Skill;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ExportCsvController extends Controller
{
    /**
     * @var string The name of the tag for the OpenAPI documentation.
     */

    /**
     * Returns the Google url.
     *
     * @return JsonResponse
     */

    public function exportSkills(): JsonResponse
    {
        try {
            ExportSkillsCsvJob::dispatch();
            return response()->json([
                'data' => [],
                'message' => trans('messages.csv_generation_inprocess'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Export Skills CSV:', $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
