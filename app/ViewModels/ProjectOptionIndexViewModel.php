<?php

namespace App\ViewModels;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class ProjectOptionIndexViewModel extends ViewModel
{
    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public $options;

    public function __construct(LengthAwarePaginator $options) {
        //
        $this->options = $options;
    }
}
