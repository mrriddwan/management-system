<?php

namespace App\Traits\Response;

use stdClass;
use Hamcrest\Type\IsObject;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

trait ResponseTrait
{
    //******************************************************************************************************************
    // Public Functions
    //******************************************************************************************************************

    /**
     * @param int $code
     * @param string|null $message
     * @param mixed $data
     * @param array $meta
     * @return object
     */
    public function success(int $code, string $message = null, mixed $data = null, array $meta = []): object
    {
        $base =
            [
                'status'  => 'success',
                'message' => $message,
                'meta'    => $this->metaMerger($meta),
            ];

        $response = $this->responseMerger($data, $base);

        return response()->json($response, $code);
    }

    /**
     * @param int $code
     * @param string $message
     * @param string $trigger_line
     * @param mixed $data
     * @param array $meta
     * @return object
     */
    public function error(int $code, string $message, string $trigger_file = "",  string $trigger_line, mixed $data = null, array $meta = []): object
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'file'    => $trigger_file,
            'line'    => $trigger_line,
            'meta'    => $this->metaMerger($meta),
            'data'    => $data
        ], $code);
    }

    //******************************************************************************************************************
    // Protected Functions
    //******************************************************************************************************************

    /**
     * @param array $meta
     * @return array
     */
    protected function metaMerger(array $meta): array
    {
        return array_merge($meta, [
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);

        Log::error($response);
        throw new ValidationException($validator, $response);
    }

    protected function responseMerger(mixed $data, array $base)
    {
        if (isset($data->resource) && $data->resource instanceof LengthAwarePaginator)
        {
            $resData = $data->resource->toArray();
        }
        elseif($data instanceof stdClass)
        {
            $resData = (array) $data;
        }
        else
        {
            $resData  = ['data' => $data];
        }

        $response = array_merge($base, $resData);


        return $response;
    }
}
