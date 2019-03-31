<?php

namespace App\ViewModels;

use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class ProjectIndexViewModel extends ViewModel
{
    public $projects;

    public function __construct(LengthAwarePaginator $projects) {
        $this->projects = $projects;
    }

}
