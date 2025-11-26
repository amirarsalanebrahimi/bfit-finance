<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('transactions/Create', [
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:INCOME,EXPENSE',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date|date_format:Y-m-d',
            'payee_payer' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255|in:POSE,CARD,ONLINE,CASH,BANK,CHECK,OTHERS',
            'tags' => 'required|array',
            'tags.*' => 'required|numeric|exists:tags,id',
            'reference_number' => 'nullable|numeric',
            'description' => 'nullable|string|max:255'
        ]);

        $transaction = Auth::user()->transactions()->create($validated);

        $transaction->tags()->sync($request->tags);

        return to_route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
