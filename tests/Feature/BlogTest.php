<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_published_posts_and_hides_drafts(): void
    {
        $author = User::factory()->create();

        Post::factory()->published()->for($author, 'author')->create([
            'title' => 'Visible Post',
        ]);

        Post::factory()->draft()->for($author, 'author')->create([
            'title' => 'Hidden Draft',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Visible Post')
            ->assertDontSee('Hidden Draft');
    }

    public function test_published_post_show_returns_ok(): void
    {
        $post = Post::factory()->published()->create();

        $this->get('/blog/'.$post->slug)
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_draft_post_show_returns_not_found(): void
    {
        $post = Post::factory()->draft()->create();

        $this->get('/blog/'.$post->slug)->assertNotFound();
    }

    public function test_category_archive_lists_published_posts_in_that_category(): void
    {
        $category = Category::factory()->create(['name' => 'Laravel']);
        $other = Category::factory()->create();

        Post::factory()->published()->for($category)->create([
            'title' => 'In Archive',
        ]);

        Post::factory()->published()->for($other)->create([
            'title' => 'Other Category',
        ]);

        Post::factory()->draft()->for($category)->create([
            'title' => 'Draft In Category',
        ]);

        $this->get('/category/'.$category->slug)
            ->assertOk()
            ->assertSee('Laravel')
            ->assertSee('In Archive')
            ->assertDontSee('Other Category')
            ->assertDontSee('Draft In Category');
    }
}
