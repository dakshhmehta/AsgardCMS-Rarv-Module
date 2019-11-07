<?php

namespace Modules\Rarv\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\User\Contracts\Authentication;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Repositories\UserTokenRepository;

class AuthController extends Controller
{

    public function __construct(UserTokenRepository $userToken)
    {
        $this->userToken = $userToken;
        $this->locale    = App::getLocale();
        $this->auth      = app(Authentication::class);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        $remember = (bool) $request->get('remember_me', false);

        $error = $this->auth->login($credentials, $remember);

        if ($error) {
            return response()->json([
                'errors' => $error,
            ], 422);
        }

        // @todo Move this logic to employee creation
        // Also fire the UserHasRegistered event.
        $user  = $this->auth->user();
        $token = $user->api_keys->first();
        if (!$token) {
            $token = $this->userToken->generateFor($user->id);
        }

        // return new UserProfileTransformer($this->auth->user());
        return response()->json([
            'access_token' => $token,
            'user'         => $user,
            'errors'       => false,
            'msg'          => 'login in successfully',
        ]);
    }

}
