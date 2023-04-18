<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ExportEmployeesCsvJob;
use App\Jobs\ExportSkillsCsvJob;
use App\Models\Role;
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
     *
     * @return JsonResponse
     */

    public function exportSkills(): JsonResponse
    {
        try {
            $userName = auth()->user()->name;
            $userGoogleId = auth()->user()->google_id;
            $userId = auth()->user()->id;
            ExportSkillsCsvJob::dispatch($userName, $userGoogleId, $userId);
            return response()->json([
                'data' => [],
                'message' => trans('messages.csv_generation_inprocess'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Export Skills CSV: ' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    /**
     *
     * @return JsonResponse
     */

    public function exportRoles(): JsonResponse
    {
        try {
            $data = Role::all();
            $csvArr = [];
            $requiredFieldsArray = [
                'name' => 'NAME',
            ];
            $header = implode(',', array_values($requiredFieldsArray));
            array_push($csvArr, $header);
            foreach ($data as $details) {
                $row = [];
                foreach ($requiredFieldsArray as $key => $value) {
                    $row[$value] = '"' . $details->$key . '"';
                }
                $dataVal = array_values($row);
                $dataVal[0] = "\n" . $dataVal[0];
                $newVal = implode(',', $dataVal);
                array_push($csvArr, $newVal);
            }
            if (!empty($csvArr) && count($csvArr) > 1) {
                return response()->json([
                    'status' => Response::HTTP_OK,
                    'message' => trans('messages.csv_generated_successfully'),
                    'data' => $csvArr,
                    'exception_message' => '',
                ]);
            } else {
                return response()->json([
                    'data' => [],
                    'exception_message' => '',
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => trans('messages.something_went_wrong')
                ]);
            }
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Export Skills CSV: ' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }

    /**
     *
     * @return JsonResponse
     */

    public function exportEmployees(): JsonResponse
    {
        try {
            $userName = auth()->user()->name;
            $userGoogleId = auth()->user()->google_id;
            $userId = auth()->user()->id;
            ExportEmployeesCsvJob::dispatch($userName, $userGoogleId, $userId);
            return response()->json([
                'data' => [],
                'message' => trans('messages.csv_generation_inprocess'),
                'exception_message' => '',
                'status' => Response::HTTP_OK
            ]);
        } catch (Exception $ex) {
            Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Export Skills CSV: ' . $ex);
            return response()->json([
                'data' => [],
                'message' => trans('messages.something_went_wrong'),
                'exception_message' => $ex,
                'status' => Response::HTTP_BAD_REQUEST
            ]);
        }
    }
}
