<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered_without_register_or_admin_links(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertDontSee('/register');
        $response->assertDontSee('/admin/login');
        $response->assertDontSee('Admin Demo');
    }

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk Panel Admin');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('beranda', absolute: false));
    }

    public function test_admin_cannot_authenticate_via_user_login_screen(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_authenticate_via_admin_login_screen(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_regular_user_cannot_authenticate_via_admin_login_screen(): void
    {
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_guest_accessing_admin_dashboard_redirects_to_admin_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_dashboard_renders_sidebar(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin Kampus']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Laporan Mahasiswa');
        $response->assertSee('Input Laporan');
        $response->assertSee('Data Mahasiswa');
    }

    public function test_beranda_has_no_admin_login_or_register_access(): void
    {
        $response = $this->get('/beranda');

        $response->assertStatus(200);
        $response->assertDontSee('/admin/login');
        $response->assertDontSee('Daftar Akun');
    }

    public function test_root_redirects_authenticated_mahasiswa_to_beranda_and_admin_to_admin_dashboard(): void
    {
        $mahasiswa = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($mahasiswa)->get('/')->assertRedirect(route('beranda'));

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/')->assertRedirect(route('admin.dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_admin_logout_redirects_to_admin_login(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/logout');

        $this->assertGuest();
        $response->assertRedirect(route('admin.login'));
    }
}
