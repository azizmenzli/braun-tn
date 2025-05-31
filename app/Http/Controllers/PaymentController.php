<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        Log::info('Callback de paiement réussi - Début', [
            'request_data' => $request->all(),
            'session_data' => session()->all(),
            'pending_order_id' => session('pending_order_id')
        ]);

        try {
            // Try to get orderId from multiple sources
            $orderId = $request->orderId ?? 
                      $request->paymentRef ?? 
                      session('pending_order_id') ?? 
                      $request->query('orderId');

            Log::info('Recherche de la transaction', [
                'orderId' => $orderId,
                'paymentRef' => $request->paymentRef,
                'all_params' => $request->all()
            ]);
            
            $transaction = PaymentTransaction::where('order_id', $orderId)
                ->orWhere('payment_details->paymentRef', $request->paymentRef)
                ->first();
            
            if (!$transaction) {
                Log::error('Transaction non trouvée', [
                    'orderId' => $orderId,
                    'paymentRef' => $request->paymentRef,
                    'all_transactions' => PaymentTransaction::all()->pluck('order_id')
                ]);
                return redirect()->route('checkout.checkout')->with('error', 'Transaction non trouvée');
            }

            Log::info('Transaction trouvée', [
                'transaction_id' => $transaction->id,
                'current_status' => $transaction->status,
                'order_id' => $transaction->order_id
            ]);

            // Update transaction
            $updated = $transaction->update([
                'status' => 'success',
                'transaction_id' => $request->transactionId ?? $request->paymentRef,
                'paid_at' => now(),
                'payment_details' => array_merge($transaction->payment_details ?? [], [
                    'success_callback' => $request->all(),
                    'success_timestamp' => now()->toIso8601String()
                ])
            ]);

            Log::info('Mise à jour de la transaction', [
                'update_success' => $updated,
                'new_status' => 'success',
                'transaction_id' => $transaction->id
            ]);

            // Update order status
            $ordersUpdated = Order::where('red_order', $transaction->red_order)
                ->update(['status' => 'traite']);

            Log::info('Mise à jour des commandes', [
                'orders_updated' => $ordersUpdated,
                'red_order' => $transaction->red_order
            ]);

            // Clear session
            session()->forget('pending_order_id');

            return redirect()->route('checkout.confirmation', ['redOrder' => $transaction->red_order])
                ->with('success', 'Paiement effectué avec succès');

        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du callback de succès', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return redirect()->route('checkout.checkout')->with('error', 'Erreur lors du traitement du paiement');
        }
    }

    public function fail(Request $request)
    {
        Log::info('Callback de paiement échoué - Début', [
            'request_data' => $request->all(),
            'session_data' => session()->all(),
            'pending_order_id' => session('pending_order_id')
        ]);

        try {
            // Try to get orderId from multiple sources
            $orderId = $request->orderId ?? 
                      $request->paymentRef ?? 
                      session('pending_order_id') ?? 
                      $request->query('orderId');

            Log::info('Recherche de la transaction', [
                'orderId' => $orderId,
                'paymentRef' => $request->paymentRef,
                'all_params' => $request->all()
            ]);
            
            $transaction = PaymentTransaction::where('order_id', $orderId)
                ->orWhere('payment_details->paymentRef', $request->paymentRef)
                ->first();
            
            if (!$transaction) {
                Log::error('Transaction non trouvée', [
                    'orderId' => $orderId,
                    'paymentRef' => $request->paymentRef,
                    'all_transactions' => PaymentTransaction::all()->pluck('order_id')
                ]);
                return redirect()->route('checkout.checkout')->with('error', 'Transaction non trouvée');
            }

            Log::info('Transaction trouvée', [
                'transaction_id' => $transaction->id,
                'current_status' => $transaction->status,
                'order_id' => $transaction->order_id
            ]);

            // Update transaction
            $updated = $transaction->update([
                'status' => 'failed',
                'payment_details' => array_merge($transaction->payment_details ?? [], [
                    'fail_callback' => $request->all(),
                    'fail_timestamp' => now()->toIso8601String()
                ])
            ]);

            Log::info('Mise à jour de la transaction', [
                'update_success' => $updated,
                'new_status' => 'failed',
                'transaction_id' => $transaction->id
            ]);

            // Clear session
            session()->forget('pending_order_id');

            return redirect()->route('checkout.checkout')
                ->with('error', 'Le paiement a échoué. Veuillez réessayer.');

        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du callback d\'échec', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return redirect()->route('checkout.checkout')->with('error', 'Erreur lors du traitement du paiement');
        }
    }

    public function checkPendingTransactions()
    {
        try {
            // Find transactions that are pending and older than 30 minutes
            $pendingTransactions = PaymentTransaction::where('status', 'pending')
                ->where('created_at', '<', now()->subMinutes(30))
                ->get();

            foreach ($pendingTransactions as $transaction) {
                Log::info('Mise à jour automatique de la transaction expirée', [
                    'transaction_id' => $transaction->id,
                    'order_id' => $transaction->order_id,
                    'created_at' => $transaction->created_at
                ]);

                $transaction->update([
                    'status' => 'failed',
                    'payment_details' => array_merge($transaction->payment_details ?? [], [
                        'auto_fail' => true,
                        'fail_reason' => 'No callback received within 30 minutes',
                        'fail_timestamp' => now()->toIso8601String()
                    ])
                ]);
            }

            return response()->json([
                'success' => true,
                'updated_count' => $pendingTransactions->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la vérification des transactions en attente', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 