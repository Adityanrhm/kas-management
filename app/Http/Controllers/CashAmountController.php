<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

use function Pest\Laravel\get;

class CashAmountController extends Controller
{
    public function index(Request $request)
    {

        // Search algorithm
        if ($request->ajax()) {
            $keyword = $request->query('q');

            $cash_amount_data_search = Bill::select('users.id', 'users.username', 'users.email', 'users.avatar', 'students.nis', 'students.user_id',)
                ->search($keyword, ['student.user.username'])
                ->with(['student.user', 'kasPayment'])->orderBy('bill.nis')->paginate(8);

            return response()->json($cash_amount_data_search);
        }

        $cash_amount_data = Bill::with(['student.user', 'kasPayment'])->paginate(8);

        return view('modules.cash-amount.cash_amount_view', compact('cash_amount_data'));
    }
}
