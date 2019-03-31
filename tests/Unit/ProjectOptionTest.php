<?php

namespace Tests\Unit;

use App\ProjectOption;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectOptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_many_projects(){

        $option = factory(ProjectOption::class)->create();
        $result = $option->projects;
        $this->assertInstanceOf(Collection::class, $result);


    }
}
