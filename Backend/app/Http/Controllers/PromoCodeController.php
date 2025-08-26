<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::latest()->get();
        return view('pages.promo-codes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('pages.promo-codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:promo_codes,code|max:50',
            'description' => 'nullable|string|max:255',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        PromoCode::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Promo Code Created',
            'message' => 'Promo code ' . $request->code . ' created successfully',
            'type' => 'success',
            'icon' => 'fa-plus-circle',
        ]);

        return redirect()->route('promo-codes')->with('success', 'Promo code ' . $request->code . ' created successfully');
    }

    public function show(PromoCode $promoCode)
    {
        return view('pages.promo-codes.show', compact('promoCode'));
    }

    public function edit(PromoCode $promoCode)
    {
        return view('pages.promo-codes.edit', compact('promoCode'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {

        $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $promoCode->id . '|max:50',
            'description' => 'nullable|string|max:255',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        $promoCode->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Promo Code Updated',
            'message' => 'Promo code ' . $promoCode->code . ' updated successfully',
            'type' => 'success',
            'icon' => 'fa-edit',
        ]);

        return redirect()->route('promo-codes')->with('success', 'Promo code ' . $promoCode->code . ' updated successfully');
    }

    public function delete(PromoCode $promoCode)
    {

        // Check if promo code is being used in orders
        if ($promoCode->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete promo code. It is being used in orders.');
        }

        $promoCode->delete();

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Promo Code Deleted',
            'message' => 'Promo code ' . $promoCode->code . ' deleted successfully',
            'type' => 'success',
            'icon' => 'fa-trash',
        ]);

        return redirect()->route('promo-codes')->with('success', 'Promo code ' . $promoCode->code . ' deleted successfully');
    }
}
