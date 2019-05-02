<?php

namespace App\ViewModels;

use App\Client;
use App\InvoiceItem;
use App\Product;
use App\Project;
use App\ProjectOption;
use App\User;
use Spatie\ViewModels\ViewModel;

class ProjectEditViewModel extends ViewModel
{
    /**
     * @var \App\Project
     */
    public $project;


    /**
     * ProjectEditViewModel constructor.
     * @param \App\Project $project
     */
    public function __construct(Project $project) {
        $this->project = $project;
    }

    public function users() {

        return User::select('id', 'first_name', 'last_name')
                   ->get()
                   ->map(function (User $user) {
                       return [
                           $user->id => $user->fullName()
                       ];
                   });
    }

    public function products() {
        return Product::all();
    }

    public function clients() {
        return Client::pluck('name', 'id');
    }

    public function options() {
        return ProjectOption::pluck('title', 'id');
    }

    public function selectedProducts() {
        return $this->project->products->map(function ($product) {
            return new InvoiceItem([
                'product_type' => Project::class,
                'product_id'   => $product->id,
                'unit_price'   => $product->price,
                'quantity'     => $product->pivot->qty,
            ]);
        });
    }
}
