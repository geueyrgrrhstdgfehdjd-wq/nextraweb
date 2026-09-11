<?php
namespace Core;

abstract class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        $viewFile = BASE_PATH . "/app/Views/{$view}.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file [{$view}] not found.");
        }
    }

    protected function json(array $data): void {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}
