<?php

declare(strict_types = 1);

namespace App\Services;

use App\Traits\RequestService;
use Illuminate\Http\Request;

use function config;

class UserService
{
    use RequestService;

    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var string
     */
    protected $secret;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->baseUri = config('services.pwe.base_uri');
        $this->secret = config('services.pwe.secret');
    }

    /**
     * @return string
     */
    public function fetchUsers($data) : string
    {
        return $this->request('POST', '/api/user', $data);
    }

    /**
     * @param $user
     *
     * @return string
     */
    public function fetchUser($user) : string
    {
        return $this->request('GET', "/api/user/{$user}");
    }

    /**
     * @param $data
     *
     * @return string
     */
    public function createUser($data) : string
    {
        return $this->request('POST', '/api/user/store', $data);
    }

    /**
     * @param $user
     * @param $data
     *
     * @return string
     */
    public function updateUser($user, $data) : string
    {
        return $this->request('PATCH', "/api/user/{$user}", $data);
    }

    /**
     * @param $user
     * @param $data
     *
     * @return string
     */
    public function updatePassword($user, $data) : string
    {
        return $this->request('PATCH', "/api/user/{$user}/password", $data);
    }

    /**
     * @param $user
     *
     * @return string
     */
    public function deleteUser($user) : string
    {
        return $this->request('DELETE', "/api/user/{$user}");
    }

     /**
     * @param $user
     *
     * @return string
     */
    public function importUser( $data) : string
    {
        return $this->request('POST', "/api/user/import", $data);
    }
    
     /**
     * @param $user
     *
     * @return string
     */
    public function exportUser($data) : string
    {
        return $this->request('POST', "/api/user/export", $data);
    }
    
         /**
     * @param $user
     *
     * @return string
     */
    public function updateUserProfile($data) : string
    {
        return $this->request('POST', "/api/user/profile/update", $data);
    }

    
    public function fetchProfile($data) : string
    {
        return $this->request('Get', '/api/user/profile', $data);
    }
}

