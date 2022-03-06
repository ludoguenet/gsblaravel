<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_access_dashboard_when_authenticated()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)->get('dashboard');

        $response->assertSee('Bienvenue sur votre compte GSB!');
    }

    public function test_user_cant_access_dashboard_when_unauthenticated()
    {
        $response = $this->get('dashboard');

        $response->assertRedirect();
        $response->assertRedirectContains('login');
    }
}
