<?php

namespace App\ViewModels;

use App\InvoiceItem;
use App\Product;
use App\Project;
use Spatie\ViewModels\ViewModel;

class CreateProjectInvoice extends ViewModel
{
    /**
     * @var \App\Project
     */
    public $project;

    public function __construct(Project $project) {
        //
        $this->project = $project;
    }

    public function selectedItems() {
        return $this->project->products->map(function (Product $product) {
            return new InvoiceItem([
                'product_type' => Product::class,
                'product_id'   => $product->id,
                'unit_price'   => $product->price,
                'quantity'     => $product->pivot->qty,
            ]);
        });
    }
}
