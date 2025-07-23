<?php

if (!function_exists('toast_success')) {
    /**
     * Add a success toast message to the session
     */
    function toast_success($message)
    {
        session()->flash('toast', [
            'type' => 'success',
            'message' => $message
        ]);
    }
}

if (!function_exists('toast_error')) {
    /**
     * Add an error toast message to the session
     */
    function toast_error($message)
    {
        session()->flash('toast', [
            'type' => 'error',
            'message' => $message
        ]);
    }
}

if (!function_exists('toast_warning')) {
    /**
     * Add a warning toast message to the session
     */
    function toast_warning($message)
    {
        session()->flash('toast', [
            'type' => 'warning',
            'message' => $message
        ]);
    }
}

if (!function_exists('toast_info')) {
    /**
     * Add an info toast message to the session
     */
    function toast_info($message)
    {
        session()->flash('toast', [
            'type' => 'info',
            'message' => $message
        ]);
    }
}
