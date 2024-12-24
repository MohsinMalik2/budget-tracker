<?php
namespace App\Http\Controllers;

use App\Models\RequestAmount;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RequestAmountController extends Controller
{
    // Show the list of request amounts for the logged-in user
    public function index()
    {
        $requestAmounts = Auth::user()->requestAmounts;

        return Inertia::render('RequestAmount/RequestAmountList', [
            'requestAmounts' => $requestAmounts,
        ]);
    }

    // Show the form to submit a new request amount
    public function create()
    {
        return Inertia::render('RequestAmount/Create');
    }

    // Store a new request amount
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string',
        ]);

        $user = Auth::user();

        RequestAmount::create(array_merge($validated, ['user_id' => $user->id]));

        return redirect()->route('request_amounts.index')->with('success', 'Request amount submitted successfully.');
    }

    // Admin can approve or reject the request amount
    public function updateStatus(RequestAmount $requestAmount)
    {
        $this->authorize('update', $requestAmount);

        $requestAmount->update(['status' => request('status')]);

        return back()->with('success', 'Request amount status updated.');
    }
}
