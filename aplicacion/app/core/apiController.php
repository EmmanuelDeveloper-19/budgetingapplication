<?php

class ApiController extends Controller
{
    protected function json(int $status, $data = null, ?string $error = null): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => $status < 400,
            'data'    => $data,
            'error'   => $error,
        ]);
        exit;
    }

    protected function get_json_body(): array
    {
        $input = json_decode(file_get_contents('php://input'), true);
        return is_array($input) ? $input : [];
    }
}
?>