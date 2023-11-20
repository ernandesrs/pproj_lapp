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

    /**
     * Resource
     *
     * @param string $resourceClass
     * @param mixed $modelInstance
     * @return \Illuminate\Http\Resources\Json\ResourceResponse
     */
    private function resource(string $resourceClass, mixed $modelInstance)
    {
        return new $resourceClass($modelInstance);
    }

    /**
     * Resource collection
     *
     * @param string $resourceClass
     * @param mixed $modelInstance
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    private function resourceCollection(string $resourceClass, mixed $modelInstance)
    {
        try {
            return $resourceClass::collection($modelInstance->withQueryString())->response()->getData();
        } catch (\Exception $e) {
            return $resourceClass::collection($modelInstance)->response()->getData();
        }
    }
}