<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;

    protected User $admin;

    protected User $editor;

    protected User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->product = Product::query()->firstOrFail();
        $this->admin = User::where('email', 'asta@gmail.com')->firstOrFail();
        $this->editor = User::where('email', 'editor@example.com')->firstOrFail();
        $this->viewer = User::where('email', 'viewer@example.com')->firstOrFail();
    }

    public function test_viewer_can_view_products_but_cannot_manage_admin_users(): void
    {
        $this->actingAs($this->viewer)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee($this->product->name)
            ->assertDontSee('Add Product')
            ->assertDontSee('Delete');

        $this->actingAs($this->viewer)
            ->get(route('products.show', $this->product))
            ->assertOk()
            ->assertDontSee('Edit')
            ->assertDontSee('Delete');

        $this->actingAs($this->viewer)
            ->get(route('products.create'))
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->post(route('products.store'), [
                'name' => 'Blocked Product',
                'description' => 'Should not be created.',
                'price' => 10,
            ])
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->get(route('products.edit', $this->product))
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->delete(route('products.destroy', $this->product))
            ->assertForbidden();

        $this->actingAs($this->viewer)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->assertDatabaseMissing('products', ['name' => 'Blocked Product']);
    }

    public function test_editor_can_create_and_edit_products_but_cannot_delete_or_manage_admin_users(): void
    {
        $this->actingAs($this->editor)
            ->get(route('products.index'))
            ->assertOk()
            ->assertSee('Add Product')
            ->assertSee('Edit')
            ->assertDontSee('Delete');

        $this->actingAs($this->editor)
            ->post(route('products.store'), [
                'name' => 'Editor Product',
                'description' => 'Created by the editor account.',
                'price' => 45.75,
            ])
            ->assertRedirect(route('products.index'));

        $createdProduct = Product::where('name', 'Editor Product')->firstOrFail();
        $this->assertSame($this->editor->id, $createdProduct->created_by);

        $this->actingAs($this->editor)
            ->put(route('products.update', $createdProduct), [
                'name' => 'Editor Product Updated',
                'description' => 'Updated by the editor account.',
                'price' => 55.25,
            ])
            ->assertRedirect(route('products.index'));

        $createdProduct->refresh();

        $this->assertSame('Editor Product Updated', $createdProduct->name);

        $this->actingAs($this->editor)
            ->delete(route('products.destroy', $createdProduct))
            ->assertForbidden();

        $this->actingAs($this->editor)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_admin_has_full_product_access(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('products.destroy', $this->product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
    }

    public function test_seeded_products_are_linked_to_their_creator_users(): void
    {
        $product = Product::query()->with('creator')->firstOrFail();

        $this->assertNotNull($product->creator);
        $this->assertNotNull($product->created_by);
    }
}
