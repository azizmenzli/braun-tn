<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentTransaction::query()
            ->with('order')
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('red_order', 'like', "%{$search}%")
                  ->orWhere('order_id', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(20);

        // Calculate statistics
        $stats = [
            'total' => PaymentTransaction::count(),
            'success' => PaymentTransaction::where('status', 'success')->count(),
            'pending' => PaymentTransaction::where('status', 'pending')->count(),
            'failed' => PaymentTransaction::where('status', 'failed')->count(),
            'total_amount' => PaymentTransaction::where('status', 'success')->sum('amount')
        ];

        return view('dashboard.transactions.index', compact('transactions', 'stats'));
    }

    public function show(PaymentTransaction $transaction)
    {
        $transaction->load('order');
        return view('dashboard.transactions.show', compact('transaction'));
    }

    public function exportPdf(PaymentTransaction $transaction)
    {
        $transaction->load('order');
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.transactions.pdf', [
            'transaction' => $transaction
        ]);

        return $pdf->stream("transaction-{$transaction->red_order}.pdf");
    }

    public function updateStatus(Request $request, PaymentTransaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,success,failed'
        ]);

        $transaction->update([
            'status' => $request->status,
            'paid_at' => $request->status === 'success' ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction status updated successfully'
        ]);
    }
} 