<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
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
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $users = User::whereHas('roles', function ($q) {
            return $q->where('slug', 'administrator');
        })->pluck("cedula")->toArray();

        return $this->successResponse($this->userService->fetchUsers(["users"=>$users]));
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
     * @param                          $user
     *
     * @return mixed
     */
    public function update(Request $request, $user)
    {
        $rules = [
            'correo' => 'required|email|unique:users,email,' . $user,
        ];

        $this->validate($request, $rules);

        $userService = $this->userService->createUser($request->all());

        if (!empty($userService)) {
            $user = User::createOrUpdate(["cedula" => $user], [
                'name' => $request->nombres . " " . $request->apellidos,
                'email' => $request->correo,
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

        if (!empty($userService)) {
            $user = User::createOrUpdate(["cedula" => $user], [
                'name' => $request->nombres . " " . $request->apellidos,
                'email' => $request->correo,
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
        if (!empty($userService)) {
            $user = User::where("cedula", $user)->delete();
        }
        return $this->successResponse("User Deleted");
    }

    public function export(Request $request)
    {
        $rules = [
            'base_format' => 'required',
            'act_on' => 'required',
        ];
        $this->validate($request, $rules);
        $users = null;

        switch ($request->act_on) {
            case 'administrator':
                $users = User::whereHas('roles', function ($q) {
                    return $q->where('slug', 'administrator');
                })->pluck("cedula");
                break;
            case 'graduate':
                $users = User::whereHas('roles', function ($q) {
                    return $q->where('slug', 'graduate');
                })->pluck("cedula");
                break;
            default:
                $users = User::All()->pluck("cedula");
                break;
        }

        $request["users"] = $users->toArray();
        $userService = $this->userService->exportUser($request->all());
        return $this->successResponse($userService);
    }

    public function import(Request $request)
    {
        $rules = [
            'file' =>  'required|mimes:xls,xlsx,scv',
            'act_on' => 'required',
            'action' => 'required',
        ];

        //$data = json_decode('{"data":{"new_users":[{"cedula":"5555555","correo":"graduate8@gmail.com","nombres":"diana","apellidos":"prueba"},{"cedula":3333333,"correo":"graduate2@gmail.com","nombres":"jose","apellidos":"prueba"},{"cedula":444444,"correo":"graduate4@gmail.com","nombres":"luis","apellidos":"prueba"},{"cedula":888888,"correo":"graduate5@gmail.com","nombres":"prueba","apellidos":"prueba"}]}}', true);
        

        $this->validate($request, $rules);

        if (!$request->hasFile('file')) {
            return $this->errorResponse("No hay un archivo disponible", 403);
        }

        $file = $request->file;
        $originalFileName = $file->getClientOriginalName();
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION); 
        $type = $file->getMimeType();
        $fileData = file_get_contents($file->getPathName());
        $fileData = trim('data:' . $type . '/' . $extension. ';base64,' . base64_encode($fileData));
        $request["file_encode"]=$fileData;
        $request["user"] = Auth::guard('api')->user()->cedula;
        $response = $this->userService->importUser($request->all());
        if(!empty($response->error)){
            return $this->errorResponse($response->error, $response->error_code);
        }
        $data = json_decode($response, true);
        if(!empty($data["data"]["new_users"])){
            foreach ($data["data"]["new_users"] as $key => $value) {

                $user = User::where("cedula", $value["cedula"]);
                
                if($user->exists()){
                    $user=$user->first();
                }else{
                    $user = User::create([
                        'name' => $value["nombres"] . " " . $value["apellidos"],
                        'email' => $value["correo"],
                        "cedula" => $value["cedula"],
                        'password' => Hash::make(explode("@", $value["correo"])[0]),
                    ]);
                }

                $role = $request->act_on == "administrator" ? "administrator" : "graduate";
                if($value["new_user"]){
                    $user->assignRole($role);   
                }else{
                    if($value["change_rol"]){
                        $user->revokeAllRoles();
                        $user->assignRole($role);
                    }
                }
            }
            return $this->successResponse("Archivo importado correctamente");    
        }
        return $this->successResponse($response);
    }
}
