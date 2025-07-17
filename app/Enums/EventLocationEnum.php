<?php

namespace App\Enums;

enum EventLocationEnum: string {
    case nacional = 'nacional';
    case internacional = 'internacional';
    case local = 'local';
}