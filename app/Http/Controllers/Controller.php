<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Exceptions\NoAccountFoundException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Exceptions\InvalidCredentialException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success Response
     *
     * @param  array  $data
     * @param  int  $status  default 200
     * @param  array  $headers
     * @return JsonResponse
     */
    public function successResponse(array $data, int $status = 200, array $headers = []): JsonResponse
    {
        $data = array_merge(['success' => true], $data);
        return response()->json($data, $status, $headers);
    }

    /**
     * @param  Exception  $e
     * @param  string|null  $message
     * @param  int  $status
     * @return mixed
     */
    public function errorMessage(Exception $e, string $message = null, int $status = 500): mixed
    {
        logger()->error($e->getMessage(), ['from' => get_called_class().' -> '.$e->getFile().' -> '.$e->getLine()]);

        if ($e instanceof NoAccountFoundException) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        if ($e instanceof InvalidCredentialException) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        if (null === $message || env('APP_ENV') === 'production') {
            $message = config('messages.SOMETHING_WENT_WRONG');
        }
        if (env('APP_ENV') !== 'production') {
            $message = $e->getMessage();
        }

        return $this->errorResponse($message, $status);
    }

    /**
     * Error Response
     *
     * @param  string  $message
     * @param  int  $status  default 200
     * @param  array  $headers
     * @return JsonResponse
     */
    public function errorResponse(string $message, int $status = 500, array $headers = []): JsonResponse
    {
        $data = [
            'success' => false,
            'data'    => [
                'message' => $message,
            ],
        ];
        return response()->json($data, $status, $headers);
    }
}
