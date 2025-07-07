@extends('errors.layout')

@php
    $errorCode = '405';
    $title = 'Método no permitido';
    $message =
        'El método HTTP que estás utilizando no está permitido para esta ruta. Por favor, verifica que estés utilizando el método correcto (GET, POST, PUT, DELETE, etc.).';
@endphp
