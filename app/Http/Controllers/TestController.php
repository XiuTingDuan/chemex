<?php

namespace App\Http\Controllers;

use App\Aspect\DcatMethodPermission;

class TestController extends Controller
{
    #[DcatMethodPermission('2')]
    public function test()
    {

    }
}
