<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MpesaService;
use App\Models\Payments;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    public function showPaymentForm()
    {
        return view('profile.form');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
            'account_reference' => 'required|string',
            'transaction_desc' => 'required|string',
        ]);

        $amount = $request->input('amount');
        $phone = $request->input('phone');
        $accountReference = $request->input('account_reference');
        $transactionDesc = $request->input('transaction_desc');
        
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        } elseif (substr($phone, 0, 3) !== '254') {
            return redirect()->route('profile.confirmation')->with([
                'status' => 'failed',
                'amount' => 0
            ]);
        }

        try {
            $response = $this->mpesaService->makePaymentRequest($amount, $phone, $accountReference, $transactionDesc);

            if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
                \DB::beginTransaction();

                $user = Auth::user(); // Get the logged-in user
                $payment = payments::create([
                    'user_id' => $user->id,
                    'transaction_id' => $response['CheckoutRequestID'],
                    'amount' => $amount,
                    'phone' => $phone,
                    'account_reference' => $accountReference,
                    'transaction_desc' => $transactionDesc,
                    'status' => 'pending',
                ]);
                
                

                \DB::commit();

                session(['CheckoutRequestID' => $response['CheckoutRequestID']]);
                return redirect()->route('profile.waiting');
            } else {
                return redirect()->route('profile.confirmation')->with([
                    'status' => 'failed',
                    'amount' => 0
                ]);
            }
            
            
            
            
            
        } catch (\Exception $e) {
            \DB::rollBack();
            // Log the error or handle it appropriately
            return redirect()->route('profile.confirmation')->with([
                'status' => 'failed',
                'amount' => 0
            ])->withErrors(['message' => 'Payment failed. Please try again later.']);
        }
    }
    
   public function showWaitingPage()
{
    $checkoutRequestID = session('CheckoutRequestID');
    $amount = session('amount', 0);// Assuming 'amount' is stored in the session
    $phone = session('phone');
    $accountReference = session('account_reference');
    $transactionDesc = session('transaction_desc');
    
    
    

    return view('profile.waiting', compact('checkoutRequestID', 'amount','phone','accountReference','transactionDesc'));
}

    public function checkPaymentStatus($checkoutRequestID)
    {
        $payment = payments::where('transaction_id', $checkoutRequestID)->first();
    
        if ($payment) {
            if ($payment->status === 'Completed') {
                return response()->json(['status' => 'completed', 'amount' => $payment->amount]);
            } elseif ($payment->status === 'Failed') {
                return response()->json(['status' => 'failed']);
            }
        }

        return response()->json(['status' => 'pending']);
    }

    public function showConfirmation(Request $request)
    {
        $status = $request->session()->get('status', 'failed');
        $amount = $request->session()->get('amount', 0);
        return view('profile.confirmation', compact('status', 'amount'));
    }
    
    public function handlePaymentTimeout($checkoutRequestID)
    {
        $payment = payments::where('transaction_id', $checkoutRequestID)->first();
        if ($payment && $payment->status === 'pending') {
            $payment->update(['status' => 'Failed']);
            return response()->json(['status' => 'failed']);
        }
        return response()->json(['status' => 'completed']);
    }
    
    public function showPayments()
    {
        $user = auth()->user();
       $payments = payments::where('user_id', $user->id)
                            ->where('status', 'Completed')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('profile.payments', compact('payments'));
    }
    
    
}
