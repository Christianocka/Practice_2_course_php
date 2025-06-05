<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToDoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test description',
            'priority' => 3,
            'tags' => ['work', 'urgent'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Задача добавлена',
                'data' => ['title' => 'Test Task'],
            ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    /** @test */
    public function it_creates_a_subtask()
    {
        $parent = Task::factory()->create(['title' => 'Parent Task']);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Subtask',
            'parent_id' => $parent->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['title' => 'Subtask', 'parent_id' => $parent->id],
            ]);
    }

    /** @test */
    public function it_updates_a_task()
    {
        $task = Task::factory()->create(['title' => 'Old Title']);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'New Title',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Задача обновлена',
                'data' => ['title' => 'New Title'],
            ]);
    }

    /** @test */
    public function it_deletes_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Задача удалена']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_fetches_tasks_with_nested_children()
    {
        $parent = Task::factory()->create(['title' => 'Root']);
        $child = Task::factory()->create(['title' => 'Child', 'parent_id' => $parent->id]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Root'])
            ->assertJsonFragment(['title' => 'Child']);
    }
}
