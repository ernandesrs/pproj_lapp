<?php

namespace App\Http\Controllers;

trait TraitApiController
{
    /**
     * Success response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function success(array $data = [])
    {
        return $this->response(true, $data);
    }

    /**
     * Fail response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function fail(array $data = [])
    {
        return $this->response(false, $data);
    }

    /**
     * Response
     *
     * @param boolean $status
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function response(bool $status, array $data = [])
    {
        return response()->json(array_merge([
            'success' => $status
        ], $data));
    }
}