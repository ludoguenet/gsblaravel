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
    public function test_user_can_access_report_index_when_authenticated()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)->get('report');

        $response->assertSee('Tableau de bord');
    }

    public function test_user_cant_access_report_index_when_unauthenticated()
    {
        $response = $this->get('report');

        $response->assertRedirect();
        $response->assertRedirectContains('login');
    }
}
