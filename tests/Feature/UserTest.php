<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users',[
            'username' => 'RANst',
            'password' => 'rahasia',
            'name' => 'Rafli Al Ghifari Nasution'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'username' => 'RANst',
                    'name' => 'Rafli Al Ghifari Nasution'
                ]
            ]);
    }
    public function testRegisterFailed()
    {
        $this->post('/api/users',[
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'username' => [
                        'The username field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ],
                    'name' => [
                        'The name field is required.'
                    ],
                ]
            ]);
    }
    public function testRegisterUsernameAlreadyExist()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users',[
            'username' => 'RANst',
            'password' => 'rahasia',
            'name' => 'Rafli Al Ghifari Nasution'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'username' => [
                        'username already registered'
                    ]
                ]
            ]);
    }
    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login',[
            'username' => 'RANst',
            'password' => 'rahasia'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'RANst',
                    'name' => 'Rafli A.N',
                ]
            ]);
        
        $user = User::where('username', 'RANst')->first();
        self::assertNotNull($user->token);
    }    
    public function testLoginFailedUsernameNotFound()
    {
        $this->post('/api/users/login',[
            'username' => 'Hooh',
            'password' => 'rahasia'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'username or password wrong'
                    ],
                ]
            ]);
    }
    public function testLoginPasswordWrong()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login',[
            'username' => 'RANst',
            'password' => 'hehe'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'username or password wrong'
                    ],
                ]
            ]);
    }
    public function testGetSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [
            'Authorization' => 'token'            
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'RANst',
                    'name' => 'Rafli A.N'
                ]
            ]);
    }
    public function testUnauthorized()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [])
        ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['unauthorized'],
                ]
            ]);
    }
    public function testInvalidToken()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [
            'Authorization' => 'hehe'            
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['unauthorized']
                ]
            ]);
    }
    public function testUpdateNameSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'RANst')->first();

        $this->patch('/api/users/current', 
            [
                'name' => 'baru'
            ],
            [
                'Authorization' => 'token'   
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'RANst',
                    'name' => 'baru'
                ]
            ]);
        $newUser = User::where('username', 'RANst')->first();

        self::assertNotEquals($oldUser->name, $newUser->name);
    }
    public function testUpdatePasswordSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'RANst')->first();

        $this->patch('/api/users/current', 
            [
                'password' => 'baru'
            ],
            [
                'Authorization' => 'token'            
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'RANst',
                    'name' => 'Rafli A.N'
                ]
            ]);
        $newUser = User::where('username', 'RANst')->first();

        self::assertNotEquals($oldUser->password, $newUser->password);
    }
    public function testUpdateFailed()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'RANst')->first();

        $this->patch('/api/users/current', 
            [
                'name' => 'barubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubarubaru'
            ],
            [
                'Authorization' => 'token'            
            ]
        )->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field must not be greater than 100 characters.'],
                ]
            ]);
    }
    public function testLogoutSuccess()
    {
        $this->seed([UserSeeder::class]);
        
        $this->delete(uri: '/api/users/logout', headers: [
            'Authorization' => 'token'
        ])->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);

        $user = User::where('username', 'RANst')->first();
        self::assertNull($user->token);
    }
    public function testLogoutFailed()
    {
        $this->seed([UserSeeder::class]);
        
        $this->delete('/api/users/logout', [
            'Authorization' => 'hoho'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => ['unauthorized']
                ]
            ]);
    }
}
