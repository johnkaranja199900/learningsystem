<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Payments;
use App\Models\User;

class MpesaController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Log the callback request for debugging
        Log::info('M-PESA Callback: ', $request->all());

        $callbackData = $request->all();

        if (isset($callbackData['Body']['stkCallback'])) {
            $stkCallback = $callbackData['Body']['stkCallback'];
            $resultCode = $stkCallback['ResultCode'];
            $resultDesc = $stkCallback['ResultDesc'];
            $checkoutRequestID = $stkCallback['CheckoutRequestID'];

            // Check if the transaction was successful
            if ($resultCode == 0) {
                $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
                $mpesaReceiptNumber = $this->getCallbackItem($callbackMetadata, 'MpesaReceiptNumber');
                $amount = $this->getCallbackItem($callbackMetadata, 'Amount');
                $phoneNumber = $this->getCallbackItem($callbackMetadata, 'PhoneNumber');
                $accountReference = $this->getCallbackItem($callbackMetadata, 'AccountReference');
                $transactionDesc = $this->getCallbackItem($callbackMetadata, 'TransactionDesc');

                // Save the payment information to the database
                $payment = payments::where('transaction_id', $checkoutRequestID)->first();
                if (!$payment) {
                    $payment = new payments();
                }
                $payment->transaction_id = $mpesaReceiptNumber;
                $payment->amount = $amount;
                $payment->phone = $phoneNumber;
                $payment->account_reference = $accountReference;
                $payment->transaction_desc = $transactionDesc;
                $payment->status = 'Completed';
                $payment->save();

                // Update the user's payment status
                $user = User::where('admission_number', $accountReference)->first();
                if ($user) {
                    $user->paid += $amount;
                    $user->save();
                }
            } else {
                $payment = payments::where('transaction_id', $checkoutRequestID)->first();
                if (!$payment) {
                    $payment = new payments();
                }
                $payment->transaction_id = $checkoutRequestID;
                $payment->status = 'Failed';
                $payment->save();
            }
        }

        return response()->json(['message' => 'Callback handled successfully']);
    }

    private function getCallbackItem($items, $name)
    {
        foreach ($items as $item) {
            if ($item['Name'] === $name) {
                return $item['Value'];
            }
        }
        return null;
    }
}
