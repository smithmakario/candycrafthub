<?php

namespace Tests\Feature;

use Tests\TestCase;

class StoryPageTest extends TestCase
{
    public function test_our_story_page_is_accessible(): void
    {
        $this->get(route('our-story'))
            ->assertOk()
            ->assertViewIs('story.index')
            ->assertSee('Where')
            ->assertSee('Nostalgia')
            ->assertSee('Our Core Ingredients');
    }
}
