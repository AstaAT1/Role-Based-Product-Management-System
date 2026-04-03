<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $editor;

    protected User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('email', 'asta@gmail.com')->firstOrFail();
        $this->editor = User::where('email', 'editor@example.com')->firstOrFail();
        $this->viewer = User::where('email', 'viewer@example.com')->firstOrFail();
    }

    public function test_asta_is_seeded_as_an_admin(): void
    {
        $this->assertTrue($this->admin->hasRole('Admin'));
        $this->assertTrue(User::where('email', 'admin@example.com')->firstOrFail()->hasRole('Admin'));
    }

    public function test_admin_can_view_user_management_pages(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('asta@gmail.com')
            ->assertSee('editor@example.com')
            ->assertSee('Viewer');

        $this->actingAs($this->admin)
            ->get(route('admin.users.edit', $this->viewer))
            ->assertOk()
            ->assertSee('Edit User Role')
            ->assertSee('viewer@example.com');
    }

    public function test_admin_can_change_a_users_role_without_stacking_roles(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.users.update', $this->viewer), [
                'role' => 'Editor',
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->viewer->refresh();

        $this->assertTrue($this->viewer->hasRole('Editor'));
        $this->assertFalse($this->viewer->hasRole('Viewer'));
        $this->assertSame(1, $this->viewer->roles()->count());
    }

    public function test_editor_and_viewer_cannot_manage_users(): void
    {
        $this->actingAs($this->editor)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->get(route('admin.users.edit', $this->editor))
            ->assertForbidden();

        $this->actingAs($this->editor)
            ->put(route('admin.users.update', $this->viewer), [
                'role' => 'Admin',
            ])
            ->assertForbidden();
    }
}
