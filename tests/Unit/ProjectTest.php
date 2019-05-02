<?php

namespace Tests\Unit;

use App\Notification;
use App\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\InvoiceSetting;
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

    /**
     * @test
     */
    public function create_invoice() {
        $project = factory(Project::class)->create();

        $invoice = (new InvoiceSetting())->setBillable($project)
                                         ->create();

        $this->assertDatabaseHas('invoices', [
            'id'            => $invoice->id,
            'billable_type' => Project::class,
            'billable_id'   => $project->id,
        ]);
    }

    /**
     * @test
     */
    public function create_notification() {
        $dateTime = Carbon::createFromFormat("Y-m-d", "2019-12-1");
        $project = factory(Project::class)->create();

        $notification = new Notification([
            'publish_at' => $dateTime
        ]);
        $project->addNotification($notification);

        $this->assertDatabaseHas('notifications', [
            'project_id' => $project->id,
            'publish_at' => $dateTime,
            'is_sent'    => false,
        ]);

    }

}
