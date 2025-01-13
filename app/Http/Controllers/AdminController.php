<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use Illuminate\Http\Request as HttpRequest;

use App\Models\Request;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/AdminDashboard');
    }

    public function showRequests()
    {
        try {
            // Fetch only the necessary columns and paginate the results
            $requests = Request::query()
                ->select(['id', 'user_id', 'requested_amount', 'reason', 'title', 'status', 'created_at'])
                ->with('user:id,name') // Eager load the user relationship (if applicable)
                ->orderBy('created_at', 'desc') // Sort by latest requests
                ->paginate(10); // Paginate with 10 requests per page

            return Inertia::render('Admin/RequestList', [
                'requests' => $requests,
            ]);
        } catch (\Exception $e) {
            // Log the error and return a generic error message
            return Inertia::render('Admin/RequestList', [
                'requests' => [],
                'error' => 'Failed to load requests. Please try again later.',
            ]);
        }
    }

    public function showRequestDetails($id)
    {
        $request = Request::with('user')->findOrFail($id); // Include user details
        return inertia('Admin/RequestPartials/RequestDetail', ['request' => $request]);
    }

    public function updateRequestStatus(HttpRequest $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:requests,id',
            'status' => 'required|string|in:Approved,Disapproved,Partial Approved',
            'remarks' => 'nullable|string', // Optional remarks
        ]);

        try {
            $requestDetails = Request::findOrFail($validated['id']);
            $requestDetails->status = $validated['status'];
            $requestDetails->remarks = $validated['remarks'] ?? null; // Store remarks if provided
            $requestDetails->save();

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
