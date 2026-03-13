<?php
function csrf_verify(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        show_error('Method Not Allowed');
    }
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $host    = $_SERVER['HTTP_HOST'];
    if (strpos($referer, 'https://' . $host . '/') !== 0 &&
        strpos($referer, 'http://'  . $host . '/') !== 0) {
        show_error('Forbidden');
    }
}
