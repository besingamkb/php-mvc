<?php

function env(string $key, mixed $default = null): mixed
{
    return getenv($key) !== false ? getenv($key) : $default;
}

function redirect($url, $status = 302)
{
    if (!headers_sent()) {
        header("Location: $url", true, $status);
        exit();
    } else {
        // fallback
        echo "<script>window.location.href='$url';</script>";
        exit();
    }
}

function responseJson($data, $status = 200)
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit();
}