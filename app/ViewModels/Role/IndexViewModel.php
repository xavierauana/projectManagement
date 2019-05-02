<?php

namespace App\ViewModels\Role;

use Spatie\Permission\Models\Role;
use Spatie\ViewModels\ViewModel;

class IndexViewModel extends ViewModel
{
    public function roles() {
        return Role::paginate();
    }
}
