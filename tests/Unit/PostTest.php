<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_post_can_be_created()
    {
        $user = User::create([
            'name' => 'Mayar',
            'email' => 'mayarmohamed3366@gmail.com',
            'password' => bcrypt('password123'),
        ]);
        $post = new Post();
        $post->title = 'Post Title';
        $post->body = 'Body of the post.';
        $post->user_id = $user->id;
        $post->save();
        $this->assertDatabaseHas('posts', [
            'title' => 'Post Title',
            'body' => 'Body of the post.',
            'user_id' => $user->id,
        ]);
        $this->assertTrue($post->user->is($user));
    }

    public function test_post_can_be_updated()
    {
        $user = User::create([
            'name' => 'Mayar',
            'email' => 'mayarmohamed3366@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $post = new Post();
        $post->title = 'Original Title';
        $post->body = 'Original Body';
        $post->user_id = $user->id;
        $post->save();
        $post->title = 'Updated Title';
        $post->body = 'Updated Body';
        $post->save();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated Body',
        ]);
    }
}
