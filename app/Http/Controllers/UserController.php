<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/login",
     * operationId="Login",
     * tags={"Login"},
     * summary="User Login",
     * description="User Login here",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *               type="object",
     *               @OA\Property(property="email",type="text",example="john@example.com"),
     *               @OA\Property(property="password",type="password",example="123456"),
     *          ),
     *      ),
     *  ),
     *
     * @OA\Response(
     *  response=201,
     *  description="User login successfully",
     *  @OA\JsonContent()
     * ),
     * @OA\Response(
     *  response=200,
     *  description="User login successfully",
     *  @OA\JsonContent()
     * ),
     * @OA\Response(
     *  response=400,
     *  description="Unauthorised",
     *  @OA\JsonContent()
     * ),
     *
     * @OA\Response(
     *  response=404,
     *  description="Unauthorised",
     *  @OA\JsonContent()
     * ),
     * ),
    */

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

        /**
     * @OA\Post(
     * path="/api/logout",
     * operationId="logout",
     * tags={"Login"},
     * summary="User logout",
     * description="User logout here",
     * security={{"bearerAuth": {}}},
     * @OA\Response(
     *  response=201,
     *  description="User logout successfully",
     *  @OA\JsonContent()
     * ),
     * @OA\Response(
     *  response=200,
     *  description="User logout successfully",
     *  @OA\JsonContent()
     * ),
     * @OA\Response(
     *  response=400,
     *  description="Unauthorised",
     *  @OA\JsonContent()
     * ),
     *
     * @OA\Response(
     *  response=404,
     *  description="Unauthorised",
     *  @OA\JsonContent()
     * ),
     * ),
    */
    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();

            return $this->sendResponse('', 'User logout successfully.');
        }else{
            return $this->sendError('Unauthorised.', ['error'=>'Something went wrong']);
        }

    }
}
