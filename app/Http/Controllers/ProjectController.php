<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Project;
use App\ViewModels\ProjectEditViewModel;
use App\ViewModels\ProjectIndexViewModel;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (optional(auth()->user())->cannot('browse_project')) {
            abort(403);
        }

        return view("projects.index",
            new ProjectIndexViewModel(Project::search($request->query('keyword'))
                                             ->paginate()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view("projects.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request) {
        Project::create($request->validated());

        return redirect()->route('projects.index')
                         ->withMessage('New project created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        return view("projects.edit", new ProjectEditViewModel($project));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Project             $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Project $project) {
        $project->update($request->validated());

        return redirect()->route('projects.index')
                         ->withMessage('Project updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        //
    }
}
