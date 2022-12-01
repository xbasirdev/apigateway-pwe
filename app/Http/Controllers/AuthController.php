<?php
declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\ForgotPasswordEvent;
use App\Events\PasswordResetEvent;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\EventoService;
use App\Services\UserService;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use JWT;
use JWTAuth;

class AuthController extends Controller
{
    private $userService;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(userService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api', ['only' => ['me', 'logout', "refresh","register"]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string',
        ];

        $this->validate($request, $rules);
        
        $credentials = ['email' => $request->email, 'password' => $request->password];
        
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->email)->first();
        
        return $this->respondWithTokenAndUser($token, $user, $user->roles);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }

    protected function respondWithTokenAndUser($token, $user, $role)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => $user,
            'role' => $role,
        ]);
    }
    public function forgotPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email',
            "url"=>"required|url"
        ];
        
        $this->validate($request, $rules);
        
        $user = User::where('email', $request->email)->first();
        
        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $t = JWTAuth::setToken($token);
        $url = $request->url."/". $token;
        $value = JWTAuth::setToken($token)->getPayload()->get('exp');
        $expiration = Carbon::parse($value)->format('d-m-y H:i') . " UTC";
        
        try {
            event(new ForgotPasswordEvent($user, $url, $expiration));
        } catch (\Throwable$th) {
            return response()->json(['error' => __("Failed to send password recovery email, try later")], 401);
        }
        return response()->json(['message' => __("recovery of sent password")]);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'password' => 'required|string',
            'password_confirmation' => 'required|same:password|string',
            "token_reset"=>"required"
        ];        

        $this->validate($request, $rules);

        try {
            JWTAuth::setToken($request->token_reset);
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            $user = User::where("id", $user->id)->first();
            if ($user) {
                $user->update([
                    'password' =>  Hash::make($request->password),
                ]);
                
                JWTAuth::invalidate($token);
                try {
                    event(new PasswordResetEvent($user));
                } catch (\Throwable$th) {

                }
                $credentials = ["email" => $user->email, "password" => $request->password];
                $token = Auth::guard('api')->attempt($credentials);
                return response()->json(['message' => __("Success")]);
            } else {
                JWTAuth::invalidate($token);
                return response()->json(['error' => __("The user does not exist")], 401);
            }
        } catch (\Throwable$th) {
            return response()->json(['error' => __("Token has expired")], 401);
        }
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'password' => 'required|string',
            'password_confirmation' => 'required|same:password|string',
        ];  

        $this->validate($request, $rules);

        $user = User::where("cedula", $request->id)->orWhere("email", $request->id)->first();
        $user->update([
            'password' =>  Hash::make($request->password),
        ]);
        return response()->json(['message' => __("success")]);
    }
}
