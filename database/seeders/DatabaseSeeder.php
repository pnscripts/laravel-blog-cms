<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );

        $admin->assignRole($adminRole);

        $categories = collect([
            ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Framework tips, routing, Eloquent, and shipping Laravel apps.'],
            ['name' => 'Filament', 'slug' => 'filament', 'description' => 'Admin panels, resources, and the Filament ecosystem.'],
            ['name' => 'Guides', 'slug' => 'guides', 'description' => 'Practical walkthroughs for getting this starter into production.'],
        ])->map(fn (array $attributes) => Category::query()->firstOrCreate(
            ['slug' => $attributes['slug']],
            $attributes
        ));

        $publishedTitles = [
            'Getting started with this blog CMS',
            'Draft vs published: how visibility works',
            'Organizing posts with categories',
            'Using Filament to manage content',
            'Roles for admin and editor access',
            'Where to go after you clone this kit',
        ];

        foreach ($publishedTitles as $index => $title) {
            Post::factory()->published()->create([
                'user_id' => $admin->id,
                'category_id' => $categories[$index % $categories->count()]->id,
                'title' => $title,
                'slug' => str()->slug($title),
                'excerpt' => 'A sample published article that ships with the demo seed so you can browse the public blog immediately.',
                'featured_image' => 'https://picsum.photos/seed/'.str()->slug($title).'/1200/630',
            ]);
        }

        Post::factory()->draft()->create([
            'user_id' => $admin->id,
            'category_id' => $categories->first()->id,
            'title' => 'Unpublished notes (draft)',
            'slug' => 'unpublished-notes-draft',
            'excerpt' => 'This draft is seeded on purpose. It should never appear on the public blog.',
        ]);
    }
}
