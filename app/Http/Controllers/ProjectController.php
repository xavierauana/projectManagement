<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Product;
use App\Project;
use App\User;
use App\ViewModels\ProjectEditViewModel;
use App\ViewModels\ProjectIndexViewModel;
use Illuminate\Auth\Access\AuthorizationException as AuthorizationExceptionAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws AuthorizationExceptionAlias
     */
    public function index(Request $request) {
        $this->authorize('browse_project');

        return view("projects.index",
            new ProjectIndexViewModel(Project::search($request->query('keyword'))
                                             ->with('client')
                                             ->paginate()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users = User::select('id', 'first_name', 'last_name')->get()
                     ->map(function (User $user) {
                         return [
                             $user->id => $user->fullName()
                         ];
                     });
        $products = Product::all();

        $clients = Client::pluck('name', 'id');

        return view("projects.create", compact('users', 'products', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Project\StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request) {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            /** @var \App\Product $project */
            $project = Project::create($data);

            collect($data['items'])->filter(function (array $product) use (
                $project
            ) {
                return $product['product_type'] === Product::class;
            })
                                   ->map(function (array $product) use (
                                       $project
                                   ) {
                                       if ($item = Product::find($product['product_id'])) {
                                           $project->addProduct($item,
                                               $product['quantity']);
                                       }
                                   });


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }


        return redirect()->route('projects.index')
                         ->withMessage('New project created!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        return view("projects.edit", new ProjectEditViewModel($project));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Project             $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Project $project) {
        $data = $request->validated();
        DB::beginTransaction();

        try {

            $project->update($data);
            $products = [];
            collect($data['items'])->filter(function ($product) {
                return $product['product_type'] == Product::class;
            })->tap(function ($collection) {
                //                dd($collection);
            })->each(function (array $product
            ) use (&$products) {
                $products[$product['product_id']] = ['qty' => $product['quantity']];
            });

            $project->products()->sync($products);


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('projects.index')
                         ->withMessage('Project updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Project $project
     * @return void
     * @throws AuthorizationExceptionAlias
     */
    public function destroy(Project $project) {
        $this->authorize('delete_project', $project);

        $project->products()->delete();

        $project->delete();

        return redirect()->route('projects.index')
                         ->with('message', 'Project deleted!');
    }
}
