<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\User;

class AuthTest extends TestCase
{
    public function testShouldForgotPassword(){


            $this->get("api/bolsaTrabajo", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure([
                'data' => ['*' =>
                    [
                        'nombre',
                        'user_id',
                        'empresa',
                        'vacantes',
                        'requisitos',
                        'carreras',
                        'fecha_publicacion',
                        'fecha_disponibilidad',
                        'contacto',
                        'created_at',
                        'updated_at',
                        
                    ]
                ],
               
            ]);
            
        }
        
    
        /**
         * /api/bolsaTrabajo/id [GET]
         */
        public function testShouldLogin(){
            $this->get("api/bolsaTrabajo/9", []);
            $this->seeStatusCode(200);
            $this->seeJsonStructure(
                ['data' =>
                    [
                        'nombre',
                        'user_id',
                        'empresa',
                        'vacantes',
                        'requisitos',
                        'carreras',
                        'fecha_publicacion',
                        'fecha_disponibilidad',
                        'contacto',
                        'created_at',
                        'updated_at',
                    ]
                ]    
            );
            
        }

}

