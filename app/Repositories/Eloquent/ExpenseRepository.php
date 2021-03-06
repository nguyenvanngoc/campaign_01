<?php

namespace App\Repositories\Eloquent;

use Exception;
use App\Models\Expense;
use App\Repositories\Contracts\ExpenseInterface;
use App\Exceptions\Api\UnknowException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class ExpenseRepository extends BaseRepository implements ExpenseInterface
{
    public function model()
    {
        return Expense::class;
    }

    public function createExpenseBuy($data)
    {
        $expense = $this->create($data['expense']);
        $qualityId = app(QualityRepository::class)->firstOrCreate(['name' => $data['quality']])->id;
        $productId = app(ProductRepository::class)->firstOrCreate(['name' => $data['name']])->id;
        $expense->products()->attach($productId, [
            'quality_id' => $qualityId,
            'quantity' => $data['quantity'],
        ]);

        return $expense;
    }

    public function updateExpenseBuy($id, $data)
    {
        parent::update($id, $data['expense']);
        $qualityId = app(QualityRepository::class)->firstOrCreate(['name' => $data['quality']])->id;
        $productId = app(ProductRepository::class)->firstOrCreate(['name' => $data['name']])->id;
        \DB::table('expense_product')
            ->where('expense_id', $id)
            ->update([
                'quality_id' => $qualityId,
                'product_id' => $productId,
                'quantity' => $data['quantity'],
            ]);

        return true;
    }

    public function forceDelete($expense)
    {
        $expense->products()->detach();

        return $expense->forceDelete();
    }

    public function deleteFromEvent($expenses)
    {
        return $expenses->delete();
    }

    public function openFromEvent($event)
    {
        $expenseIds = $event->expenses()->onlyTrashed()->pluck('id');
        \DB::table('expense_product')
            ->whereIn('expense_id', $expenseIds)
            ->update(['deleted_at' => null]);

        return $event->expenses()->restore();
    }
}
