<?php

namespace App\Http\Controllers;

use App\ViewModels\Role\IndexViewModel;

class RoleController extends Controller
{
    public function index() {
        return view("roles.index", new IndexViewModel);
    }
}
