@extends('errors.layout')

@php
    $errorCode = '429';
    $title = 'Demasiadas solicitudes';
    $message =
        'Has enviado demasiadas solicitudes en poco tiempo. Por favor, espera un momento antes de intentarlo nuevamente.';
@endphp
