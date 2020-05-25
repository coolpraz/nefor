<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_search_threads()
    {
        $this->withoutExceptionHandling();

        config(['scout.driver' => 'algolia']);

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "A thread with the foobar term."], 2);

        do {
            sleep(.25);
            $results = $this->getJson("/threads/search?q=foobar")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
