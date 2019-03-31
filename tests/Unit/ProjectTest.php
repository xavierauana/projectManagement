<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_many_project_options() {
            $project = factory(Project::class)->create();
            $result = $project->options;
            $this->assertInstanceOf(Collection::class, $result);

    }

}
