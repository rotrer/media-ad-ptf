<?php
class DfpExceptionHandler {
    public static function handle($error) {
        echo 'DFP API error: ' . $error->getMessage();
    }
}