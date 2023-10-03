<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Capybara API",
 *      description="API for tracking Capybara observations",
 *      @OA\Contact(
 *          email="caleboki@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */
class OpenApiSpec {}
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
