<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpenseExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(Expense::getAllExpenses());
    }

    public function headings(): array
    {
        return ['voyage_id', 'friend_id', 'description', 'cost'];
    }
}
