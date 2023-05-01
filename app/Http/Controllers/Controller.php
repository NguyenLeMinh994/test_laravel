<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
*
* @OA\Info(
* version="1.0",
* title="Example API",
* description="Example info",
* @OA\Contact(name="Swagger API Team")
* )
*/

class Controller extends BaseController
{


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
