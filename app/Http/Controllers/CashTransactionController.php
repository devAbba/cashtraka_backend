<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;

class CashTransactionController extends Controller
{
    /**
     * Gets list of user transactions
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $page_size = $request->query('page_size');
        $transactions = Transaction::query()->paginate($page_size);

        return TransactionResource::collection($transactions);
    }

    /**
     * Creates a new transaction in DB
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function store(Request $request)
    {
        $form_fields = $request->validate([
            'description' => 'required',
            'amount' => 'required'
        ]);

        $form_fields['user_id'] = auth()->id();

        $created = Transaction::create($form_fields);

        return new TransactionResource($created);
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        if (! Gate::allows('delete-transaction', $transaction)) {
            abort (403);
        }

        $response = $transaction->delete();

        return response()->json([
            'data' => 'success'
        ]);
    }
}
