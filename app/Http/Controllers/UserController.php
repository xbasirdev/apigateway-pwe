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
        $user = User::where("cedula", $user)->first();   
        if(empty($user)){
            return $this->errorResponse("El usuario no existe",404);
        }     
        $data = json_decode($this->userService->fetchUser($user->cedula));
        $data->data->role = $user->roles->first()->slug;
        return $this->successResponse(json_encode($data));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if(!$user->hasRole('administrator')){
            return $this->errorResponse("El usuario no tiene permisos para esta accion",404);
        }

        $request["user"] = $user->cedula;
        $rules = [
            "nombres"=>"required|string",
            "apellidos"=>"required|string",
            "telefono"=>array("nullable","string","regex:/0(2(12|3[4589]|4[0-9]|[5-8][1-9]|9[1-5])|(4(12|14|16|24|26)))-?[0-9]{7}$/"),
            'correo' => 'required|email|unique:users,email',
            'cedula' => array('required','string','unique:users,cedula','regex:/[VvEe]-[0-9]{6,}$/'),
            'password' => 'required|string',
            'password_confirm' => 'required|same:password|string',
            "form_type"=>"required"
        ];

        if($request->form_type == "graduate"){
            $rules += [
                "periodo_egreso"=>array("required","regex:/^[12][0-9]{3}[-][1-9]{1}$/"),
                "correo_personal"=>"nullable|email",
                "fecha_egreso"=>"nullable|date",
                "carrera"=>"required"
            ];                   
        }
        $this->validate($request, $rules);    
        $userService = $this->userService->createUser($request->all()); 

        if(!empty($userService)){
            $user = User::create([
                'name' => $request->nombres ." ". $request->apellidos,
                'cedula'=>$request->cedula,
                'email'=> $request->correo,
                'password'=> Hash::make($request->password),
            ]);
        }

        $role = $request->form_type == "graduate" ?"graduate" : "administrator";
        $user->assignRole($role);
        
        return $this->successResponse($user);
    }

    public function update(Request $request, $user)
    {        
        $user_guard = Auth::guard('api')->user();
        if(!$user_guard->hasRole('administrator') && $user_guard->cedula != $request->cedula){
            return $this->errorResponse("El usuario no tiene permisos para esta accion",404);
        }
        $request["user"] = $user_guard->cedula;
        $user = User::where(["cedula" => $user])->first();
        
        if($request->form_type == "administrator"){
            $rules = [
                "nombres"=>"required|string",
                "apellidos"=>"required|string",
                "telefono"=>array("nullable","string","regex:/0(2(12|3[4589]|4[0-9]|[5-8][1-9]|9[1-5])|(4(12|14|16|24|26)))-?[0-9]{7}$/"),
                'correo' => 'required|email|unique:users,email,'.$user->id,
                'cedula' => array('required','string','unique:users,cedula,'.$user->id, 'regex:/[VvEe]-[0-9]{6,}$/'),
                "form_type"=>"required"
            ];
        }

        if($request->form_type == "profile"){
            $rules = ["telefono"=>array("nullable","string","regex:/0(2(12|3[4589]|4[0-9]|[5-8][1-9]|9[1-5])|(4(12|14|16|24|26)))-?[0-9]{7}$/")];
            if( !$user_guard->hasRole('administrator')){
                $rules+= ["correo_personal"=>"nullable|email"];
            }
        }

        if($request->form_type == "graduate"){
            $rules += [
                "periodo_egreso"=>array("required","regex:/^[12][0-9]{3}[-][1-9]{1}$/"),
                "correo_personal"=>"nullable|email",
                "fecha_egreso"=>"nullable|date",
                "carrera"=>"required"
            ];                       
        }

        $this->validate($request, $rules);
        $request["role"]= $user_guard->hasRole('administrator') ? "administrator" : "graduate";  
        $userService = $this->userService->updateUser($user->cedula, $request->all()); 
        return $userService;
        if($user->hasRole('administrator') && !empty($userService) && $request->form_type != "profile") {
            $user->update([
                'name' => $request->nombres . " " . $request->apellidos,
                'email' => $request->correo,
                'cedula'=>strtoupper($request->cedula),
            ]);
        }

        return $this->successResponse(["message"=>"Usuario actualizado"]);
    }

    public function updateRole(Request $request, $user)
    {
        $user_guard = Auth::guard('api')->user();
        if(!$user_guard->hasRole('administrator')){
            return $this->errorResponse("El usuario no tiene permisos para esta accion",404);
        }
       
        $user = User::where("cedula", $user)->first();
        $role = $user->hasRole('administrator') ? "graduate":"administrator";
        $user->revokeAllRoles();
        $user->assignRole($role);
        return $this->successResponse($user);
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function destroy($user)
    {
        $user_guard = Auth::guard('api')->user();
        if(!$user_guard->hasRole('administrator')){
            return $this->errorResponse("El usuario no tiene permisos para esta accion",404);
        }

        $userService = $this->userService->deleteUser($user);
        if (!empty($userService)) {
            $user = User::where("cedula", $user)->first()->delete();
        }
        return $this->successResponse(["message"=>"Usuario Eliminado correctamente"]);
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
