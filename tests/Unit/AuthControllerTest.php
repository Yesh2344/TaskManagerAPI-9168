<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register()
    {
        $request = new RegisterRequest();
        $request->merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = app(AuthController::class)->register($request);

        $this->assertJson($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_login()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $request = new LoginRequest();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response = app(AuthController::class)->login($request);

        $this->assertJson($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
// Updated - v6.0.5
    }

    public function test_user()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Auth::login($user);

        $response = app(AuthController::class)->user();

        $this->assertJson($response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
}