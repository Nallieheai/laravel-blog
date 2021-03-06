<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\BlogPost;
use App\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testNoBlogPostsWhenDatabaseIsEmpty()
    {
        $response = $this->get('/posts');
        $response->assertSeeText("No blog posts yet");
    }

    public function testSeeOneBlogPostWhenThereIsOnlyOneWithNoComments()
    {
        $post = $this->createDummyBlogPost();

        $response = $this->get('/posts');
        $response->assertSeeText("New title");
        $response->assertSeeText('No comments yet!');
        
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New title'
        ]);
    }

    public function testSeeOneBlogPostWithComments()
    {
        $post = $this->createDummyBlogPost();
        factory(Comment::class, 4)->create(['blog_post_id' => $post->id]);
        $response = $this->get('/posts');
        $response->assertSeeText('4 comments!');
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];
        
        $this->actingAs($this->user())->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x' 
        ];

        $this->actingAs($this->user())->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        // dd($messages->getMessages());
        $this->assertEquals($messages['title'][0], "The title must be at least 5 characters.");
        $this->assertEquals($messages['content'][0], "The content must be at least 10 characters.");
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'A new title',
            'content' => 'Content that has been updated' 
        ];

        $this->actingAs($user)->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new title',
            'content' => 'Content that has been updated' 
        ]);
    }

    public function testDeleteValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);
        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $this->actingAs($user)->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');
         
        $this->assertEquals(session('status'), 'Blog post was deleted!');
        $this->assertSoftDeleted('blog_posts', $post->toArray());
        // $this->assertDatabaseMissing('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New title';
        // $post->content = 'Content of the blog post';
        // $post->save();
        return factory(BlogPost::class)->state('new-title')->create([
            'user_id' => $userId ?? $this->user()->id
        ]);
    }
}