<?php
namespace Core;

final class ApiResponse {
    public static function response(array $data, int $status): void {
        http_response_code($status);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
    
    public static function error(string $message = '', mixed $errors = [], int $status = 400): void {
        self::response([
            'success'   => false,
            'message'   => $message,
            'errors'    => $errors,
            'status'    => $status
        ], $status);
    }
    
    public static function success(string $message = '', mixed $data = [], int $status = 200): void {
        self::response([
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
            'status'    => $status
        ], $status);
    }
}