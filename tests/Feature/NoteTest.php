<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Note;

class NoteTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_cannot_view_create_note_page()
    {
        $this->withExceptionHandling();

        openSchedule();

        $this
            ->signIn()
            ->get('/notes/create')
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_view_create_note_page()
    {
        $this
            ->signInAdmin()
            ->get('/notes/create')
            ->assertStatus(200)
        ;
    }

    public function test_creates_note()
    {
        $note = make(Note::class);

        $response = $this
            ->signInAdmin()
            ->post('/notes', $note->toArray())
        ;

        $response->assertStatus(302);

        $this->get($response->headers->get('Location'))
            ->assertSee($note->body)
        ;
    }
}
