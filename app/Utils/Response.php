<?php

namespace App\Utils;

use Illuminate\Support\Facades\Response as BaseResponse;

final class Response
{
    public  static function make(int $code, string $message, mixed $data = null)
    {
        if (!is_null($data)) {
            return BaseResponse::make([
                'code' => $code,
                'message' => $message,
                'data' => $data,
            ], $code);
        }

        return BaseResponse::make([
            'code' => $code,
            'message' => $message,
        ], $code);
    }
}
