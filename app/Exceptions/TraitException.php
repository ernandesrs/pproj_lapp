<?php

namespace App\Exceptions;

trait TraitException
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        $errors = session()->get("validator_errors", null);

        return response()->json(array_merge([
            'success' => false,
            'error' => class_basename($this),
            'message' => $this->message
        ], $errors ? ['errors' => $errors] : []), $this->code);
    }
}