<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    private $userService;

    /**
     * UserController constructor.
     *
     * @param \App\Services\UserService $userService
     */
    
    public function __construct(userService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->successResponse($this->userService->fetchUsers());
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function show($user)
    {
        return $this->successResponse($this->userService->fetchUser($user));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $rules = [
            'correo' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'password_confirm' => 'required|same:password|string',
        ];

        $this->validate($request, $rules);

        $userService = $this->userService->createUser($request->all());

        if(!empty($userService)){
            $user = User::create([
                'name' => $request->nombres ." ". $request->apellidos,
                'email'=> $request->correo,
                'password'=> Hash::make($request->password),
            ]);
        }
        
        return $this->successResponse($this->userService->createUser($request->all()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $user
     *
     * @return mixed
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'correo' => 'required|email|unique:users,email,'.$user,
        ];

        $this->validate($request, $rules);

        $userService = $this->userService->createUser($request->all());

        if(!empty($userService)){
            $user = User::createOrUpdate(["cedula"=>$user], [
                'name' => $request->nombres ." ". $request->apellidos,
                'email'=> $request->correo,
            ]);
        }

        return $this->successResponse($this->userService->updateUser($user, $request->all()));
    }

    public function updatePassword(Request $request, $user)
    {
        $rules = [
            'password' => 'required|string',
            'password_confirm' => 'required|same:password|string',
        ];

        $this->validate($request, $rules);
        $user = User::where("cedula", $user);

        if(!empty($userService)){
            $user = User::createOrUpdate(["cedula"=>$user], [
                'name' => $request->nombres ." ". $request->apellidos,
                'email'=> $request->correo,
            ]);
        }

        return $this->successResponse($this->userService->updateUser($user, $request->all()));
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function destroy($user)
    {
        $userService = $this->successResponse($this->userService->deleteUser($user));
        if(!empty($userService)){
            $user = User::where("cedula", $user)->delete();
        }
        return $this->successResponse("User Deleted");
    }

    public function export(Request $request)
    {
        $rules = [
            'base_format' => 'required',
            'act_on' =>'required'
        ];
        $this->validate($request, $rules);
        $userService =$this->userService->exportUser($request->all());
        
        return $this->successResponse($userService);
    }

    public function import(Request $request)
    {
        return "dd";
        $userService = $this->successResponse($this->userService->importUser($request));
        if(!empty($userService)){
           
        }
        return $this->successResponse( );
    }
}
