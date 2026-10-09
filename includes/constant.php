<?php
//database Constant (guarded so double-inclusion is safe)
defined("DB_SERVER") || define("DB_SERVER", "localhost");
defined("DB_USER") || define("DB_USER", "root");
defined("DB_PASS") || define("DB_PASS", "");
defined("DB_NAME") || define("DB_NAME", "astro_sport_club");

// Auto-detect site base URL so the same code works on localhost and the live server.
// Override by defining SITE_PATH / ADMIN_PATH before this file is included if needed.
if (!defined("SITE_PATH") || !defined("ADMIN_PATH")) {
    $base_scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $base_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "localhost";
    $base_path = "";
    if (!empty($_SERVER['DOCUMENT_ROOT'])) {
        $doc_root = rtrim(str_replace("\\", "/", realpath($_SERVER['DOCUMENT_ROOT'])), "/");
        $app_dir  = str_replace("\\", "/", realpath(__DIR__ . "/.."));
        if ($doc_root !== "" && $app_dir !== "" && strpos($app_dir, $doc_root) === 0) {
            $base_path = substr($app_dir, strlen($doc_root));
        }
    }
    $base_url = $base_scheme . "://" . $base_host . $base_path . "/";
    defined("SITE_PATH") || define("SITE_PATH", $base_url);
    defined("ADMIN_PATH") || define("ADMIN_PATH", $base_url . "manager/");
}
?>