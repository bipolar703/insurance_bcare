<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

function test()
{
    return Auth::user();
}