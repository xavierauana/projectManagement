<?php

namespace App;

use App\Contracts\BillableInterface;
use App\Contracts\DiscountableInterface;
use App\Contracts\InvoicePaymentReferenceInterface;
use App\Contracts\PayeeInterface;
use App\Contracts\SearchableInterface;
use App\Enums\InvoiceStatus;
use App\Traits\Discountable;
use App\Traits\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Spatie\Activitylog\Traits\LogsActivity;

class Invoice extends Model
    implements DiscountableInterface, SearchableInterface
{
    use Discountable, LogsActivity, Searchable, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'billable',
        'billable_type',
        'billable_id',
        'invoice',
        'due_date',
        'status',
        'internal_note',
        'note'
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
    ];

    protected static $logOnlyDirty = true;

    protected $searchableColumns = [
        'due_date'
    ];

    // Relation
    public function payments(): Relation {
        return $this->hasMany(InvoicePayment::class);
    }

    public function billable(): Relation {
        return $this->morphTo();
    }

    public function items(): Relation {
        return $this->hasMany(InvoiceItem::class);
    }

    // Scope
    public function scopeWithStatus(Builder $q, InvoiceStatus $status
    ): Builder {
        return $q->where('invoices.status', $status->getValue());
    }

    // Mutator
    public function setInvoiceNumberAttribute($value): void {
        $this->attributes['invoice_number'] = $this->setInvoiceNumber($value);
    }

    public function setStatusAttribute($value): void {
        if (new InvoiceStatus($value)) {
            $this->attributes['status'] = $value;
        } elseif ($value instanceof InvoiceStatus) {
            $this->attributes['status'] = $value->getValue();
        } else {
            throw new InvalidArgumentException();
        }
    }

    public function setBillableAttribute(BillableInterface $model): void {
        $this->attributes['billable_type'] = get_class($model);
        $this->attributes['billable_id'] = $model->id;
    }

    // Accessor
    public function getStatusAttribute(string $value): InvoiceStatus {
        return new InvoiceStatus($value);
    }


    // Helpers
    static public function getInvoiceNumber(
        Client $client = null, Project $project = null
    ) {

        if (is_null($client)) {
            throw new InvalidArgumentException("Client cannot be null");
        }

        $count = str_pad(Invoice::count() + 1, 5, 0, STR_PAD_LEFT);

        return sprintf('%s_%s', "Invoice", $count);

    }

    public function dueDate(): Carbon {
        return $this->due_date;
    }

    public function addItem(InvoiceItem $item): void {
        $this->items()->save($item);
    }

    public function addItems(Collection $items): void {
        $items->each(function (InvoiceItem $item) {
            $this->addItem($item);
        });
    }

    public function invoiceItems(): Collection {
        return $this->items;
    }

    public function subtotal(): float {
        return $this->invoiceItems()->reduce(function ($carry, InvoiceItem $item
        ) {
            return $carry += $item->total();
        }, 0);
    }

    public function total(): float {

        $sum = $this->subtotal();

        foreach ($this->discounts as $discount) {
            $sum = $discount->calculate($sum);
        }

        return $sum;
    }

    public function pay(
        float $amount, InvoicePaymentReferenceInterface $reference = null
    ): float {
        $this->payments()->create(compact('amount', 'reference'));

        $sum = $this->total() - ($this->payments->sum->amount);

        if ($sum == 0.0) {
            $this->status = InvoiceStatus::Paid();
            $this->save();
        }

        return $sum;
    }

    public function remaining(): float {
        $sum = $this->subtotal();

        $paidAmount = $this->payments->sum->amount;

        return $sum - $paidAmount;
    }

    private function setInvoiceNumber($value) {
        return $value ?? Str::uuid();
    }

    public function getPayee(): PayeeInterface {
        return $this->billable->getPayee();
    }

}
