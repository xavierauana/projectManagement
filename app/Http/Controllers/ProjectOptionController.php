<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectOption\StoreRequest;
use App\ProjectOption;
use App\ViewModels\ProjectOptionIndexViewModel;
use Illuminate\Http\Request;

class ProjectOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (optional(auth()->user())->cannot('browse_project_option')) {
            abort(403);
        }

        return view("project_options.index",
            new ProjectOptionIndexViewModel(ProjectOption::search($request->query('keyword'))
                                                         ->paginate()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (optional(auth()->user())->cannot('create_project_option')) {
            abort(403);
        }

        return view("project_options.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ProjectOption\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request) {

        ProjectOption::create($request->validated());

        return redirect()->route('project_options.index')
                         ->withMessage("Project option created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjectOption $projectOption
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectOption $projectOption) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectOption $projectOption
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectOption $projectOption) {
        if (optional(auth()->user())->cannot('edit_project_option',
            $projectOption)) {
            abort(403);
        }

        return view("project_options.edit", ['option' => $projectOption]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ProjectOption       $projectOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectOption $projectOption) {
        $projectOption->update($request->all());

        return redirect()->route('project_options.index')
                         ->withMessage("Project option updated!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectOption $projectOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectOption $projectOption) {
        if (optional(auth()->user())->cannot('delete_project_option',
            $projectOption)) {
            abort(403);
        }
        $projectOption->delete();

        return response()->json(['status' => 'completed']);

    }
}
