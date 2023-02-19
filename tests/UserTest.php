<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    protected $user;

    public function loginWithUserGetJWT()
    {

        $user = factory(User::class)->create(
            [
                'password' => Hash::make("366643"),
            ]
        );

        $user->assignRole("administrator");
        $this->user = $user;
        $content = $this
            ->post(
                'api/auth/login',
                [
                    'email' => $user->email,
                    'password' => '366643',
                ]
            )
            ->seeStatusCode(200)
            ->response->getContent();
              

        $token = json_decode($content)->access_token;
        
        return $token;

    }

    public function testShouldReturnAllUsersAdmin()
    {
        $token = $this->loginWithUserGetJWT();
        
        $this->get('api/user?token='.$token);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    "apellidos",
                    "cedula",
                    "correo",
                    "created_at",
                    "nombres",
                    "telefono",
                    "updated_at",
                    "user_id",                       
                ]
            ],
           
        ]);
      
    }

    public function testShouldReturnUserAdmin(){
        $token = $this->loginWithUserGetJWT();
        $this->get("api/user/?user=v-1111111&token=".$token);
        $this->seeStatusCode(200);
      
    }

    public function testShouldReturnUserEgresado(){
        $token = $this->loginWithUserGetJWT();
        $this->get("api/user/?user=V-2222222&token=".$token);
        $this->seeStatusCode(200);
      
    }

}

       