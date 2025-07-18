<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;

use function Pest\Laravel\get;

class CashNominalController extends Controller
{
    public function index(Request $request)
    {

        // Search algorithm
        if ($request->ajax()) {
            $keyword = $request->query('q');
            $cash_amount_data_search = Bill::with(['student.user', 'kasPayment'])
                ->join('students', 'bills.student_id', '=', 'students.id')
                ->search($keyword, ['student.user.username', 'student.nis'])
                ->orderBy('students.nis', 'ASC')
                ->select('bills.id', 'bills.week', 'bills.month', 'bills.year', 'bills.nominal', 'bills.status', 'bills.due_date', 'bills.student_id')
                ->paginate(8);
            return response()->json($cash_amount_data_search);
        }

        $cash_nominal_data = Bill::getBillKasPaymentData()->with(['student.user'])->orderBy('students.nis')->paginate(8);

        return view('modules.cash-nominal.cash_nominal_view', compact('cash_nominal_data'));
    }
}
