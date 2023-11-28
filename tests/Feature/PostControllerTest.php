<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test the creation of a new post.
     *
     * @return void
     */
    public function testCreatePost()
    {
        $response = $this->post(route('posts.store'), [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'author' => 'Test Author',
        ]);

        $response->assertStatus(302); // 302 is the status code for a redirect
        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'author' => 'Test Author',
        ]);
    }

    /**
     * Test the update of an existing post.
     *
     * @return void
     */
    public function testUpdatePost()
    {
        $post = Post::create([
            'title' => 'Original Title',
            'content' => 'Original Content',
            'author' => 'Original Author',
        ]);

        $response = $this->put(route('posts.update', $post->id), [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'author' => 'Updated Author',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'author' => 'Updated Author',
        ]);
    }

    /**
     * Test the deletion of a post.
     *
     * @return void
     */
    public function testDeletePost()
    {
        $post = Post::create([
            'title' => 'Post to be deleted',
            'content' => 'Content to be deleted',
            'author' => 'Author to be deleted',
        ]);

        $response = $this->delete(route('posts.destroy', $post->id));

        $response->assertStatus(302);
        $response->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
