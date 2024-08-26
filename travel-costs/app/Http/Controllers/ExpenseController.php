<?php

namespace App\Http\Controllers;

use App\Exports\ExpenseExport;
use App\Http\Resources\Expense\ExpenseCollection;
use App\Http\Resources\Expense\ExpenseResource;
use App\Models\Expense;
use App\Models\Friend;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CSV;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::all();
        if (is_null($expenses)) {
            return response()->json('No expenses found', 404);
        }
        return response()->json(new ExpenseCollection($expenses));
    }

    public function exportCSV()
    {
        return CSV::download(new ExpenseExport, 'expensess.csv');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' =>  'required|string|max:255',
            'date' =>  'required|date',
            'cost' => 'required|integer|between:1,5000',
            'voyage_id' => 'required|integer',
            'friend_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $friend = Friend::find($request->friend_id);
        if (is_null($friend)) {
            return response()->json('Friend not found!', 404);
        }

        $voyage = Voyage::find($request->voyage_id);
        if (is_null($voyage)) {
            return response()->json('Voyage not found!', 404);
        }

        if (
            strtotime(date('Y-m-d', strtotime($request->date))) < strtotime(date('Y-m-d', strtotime($voyage->arrival))) ||
            strtotime(date('Y-m-d', strtotime($request->date))) > strtotime(date('Y-m-d', strtotime($voyage->departure)))
        ) {
            return response()->json('Can not insert the date outside of voyage dates!', 403);
        }

        $voyage->total_cost = $voyage->total_cost + $request->cost;
        $voyage->save();

        $expense = Expense::create([
            'description' => $request->description,
            'date' => $request->date,
            'cost' => $request->cost,
            'voyage_id' => $request->voyage_id,
            'friend_id' => $request->friend_id,
        ]);

        return response()->json([
            'Expense documented' => new ExpenseResource($expense)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($expense_id)
    {
        $expense = Expense::find($expense_id);
        if (is_null($expense)) {
            return response()->json('Expense not found', 404);
        }
        return response()->json(new ExpenseResource($expense));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $validator = Validator::make($request->all(), [
            'description' =>  'required|string|max:255',
            'date' =>  'required|date',
            'cost' => 'required|integer|between:1,5000',
            'voyage_id' => 'required|integer',
            'friend_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $friend = Friend::find($request->friend_id);
        if (is_null($friend)) {
            return response()->json('Friend not found!', 404);
        }

        $voyage = Voyage::find($request->voyage_id);
        if (is_null($voyage)) {
            return response()->json('Voyage not found!', 404);
        }

        if (
            strtotime(date('Y-m-d', strtotime($request->date))) < strtotime(date('Y-m-d', strtotime($voyage->arrival))) ||
            strtotime(date('Y-m-d', strtotime($request->date))) > strtotime(date('Y-m-d', strtotime($voyage->departure)))
        ) {
            return response()->json('Can not insert the date outside of voyage dates!', 403);
        }

        $voyage->total_cost = $voyage->total_cost - $expense->cost;
        $voyage->total_cost = $voyage->total_cost + $request->cost;
        $voyage->save();

        $expense->description = $request->description;
        $expense->date = $request->date;
        $expense->cost = $request->cost;
        $expense->voyage_id = $request->voyage_id;
        $expense->friend_id = $request->friend_id;
        $expense->save();

        return response()->json([
            'Expense updated' => new ExpenseResource($expense)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json('Expense removed');
    }
}
