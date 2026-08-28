<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Filament\Facades\Filament;
use Filament\Auth\Pages\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_seeded_admin_can_access_filament_panel(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::query()->where('email', 'admin@example.com')->first();

        $this->assertNotNull($admin);
        $this->assertTrue($admin->canAccessPanel(Filament::getPanel('admin')));
    }

    public function test_user_without_admin_or_editor_role_cannot_access_panel(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->canAccessPanel(Filament::getPanel('admin')));
    }

    public function test_editor_can_access_panel(): void
    {
        Role::create(['name' => 'editor', 'guard_name' => 'web']);

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $this->assertTrue($editor->canAccessPanel(Filament::getPanel('admin')));
    }

    public function test_seeded_admin_can_log_into_filament(): void
    {
        $this->seed(DatabaseSeeder::class);

        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'admin@example.com',
                'password' => 'password',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect('/admin');
    }
}
