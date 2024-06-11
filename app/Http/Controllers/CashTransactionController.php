<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class CashTransactionController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        $page_size = $request->query('page_size') ?? 6;
        $transactions = Transaction::latest()->paginate($page_size);
        return response()->json($transactions);
    }

    public function store(Request $request): JsonResponse
    {
        $form_fields = $request->validate([
            'description' => 'required',
            'amount' => 'required'
        ]);

        $form_fields['user_id'] = auth()->id();

        $res = Transaction::create($form_fields);

        return response()->json($res);
    }

    public function destroy(Transaction $transaction)
    {
        if (! Gate::allows('delete-transaction', $transaction)) {
            abort (403);
        }

        $response = $transaction->delete();

        return response()->json($response);
    }
}
