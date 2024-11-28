<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{    
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'username',
        'password',
        'name'
    ];

    /*
     *
     * Implements Function from Authenticable Clas
     * 
     */
    public function getAuthIdentifier() 
    {
        return $this->username;
    }

    public function getAuthIdentifierName() 
    {
        return 'username';
    }

    public function getAuthPassword() 
    {
        return $this->password;
    }

    public function getAuthPasswordName() 
    {
        return 'password';
    }

    public function getRememberToken() 
    {
        return $this->token;
    }

    public function getRememberTokenName() 
    {
        return 'token';
    }

    public function setRememberToken($token) 
    {
        $this->token = $token;
    }
}
