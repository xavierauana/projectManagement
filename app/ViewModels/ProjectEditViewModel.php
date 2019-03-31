<?php

namespace App\ViewModels;

use App\Project;
use App\ProjectOption;
use Spatie\ViewModels\ViewModel;

class ProjectEditViewModel extends ViewModel
{
    /**
     * @var \App\Project
     */
    public $project;
    public $options;

    /**
     * ProjectEditViewModel constructor.
     * @param \App\Project $project
     */
    public function __construct(Project $project) {
        //
        $this->project = $project;
        $this->options = ProjectOption::pluck('title', 'id');
    }
}
