<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Waiting for Payment</title>
    <!-- Bootstrap CSS link assuming Bootstrap is used -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Waiting for Payment') }}</div>
                    <div class="card-body">
                        <p>{{ __('Please complete the payment on your phone. This page will refresh once the payment is processed.') }}</p>
                        <button id="completePaymentBtn" class="btn btn-primary">{{ __('Complete') }}</button>
                        <button id="retryPaymentBtn" class="btn btn-secondary">{{ __('Retry') }}</button>
                        <p id="timeoutMessage" class="text-danger" style="display: none;">{{ __('Payment session has expired. Please try again.') }}</p>

                        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const timeoutMessage = document.getElementById('timeoutMessage');
        const timeoutDuration = 5 * 60 * 1000; // 5 minutes
        const checkoutRequestID = '{{ $checkoutRequestID }}';

        function checkPaymentStatus() {
            fetch('/profile/check-status/' + checkoutRequestID, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'completed') {
                    window.location.href = '/profile/confirmation?status=success&amount=' + data.amount;
                } else if (data.status === 'failed') {
                    window.location.href = '/profile/confirmation?status=failed';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        setInterval(checkPaymentStatus, 5000);

        document.getElementById('completePaymentBtn').addEventListener('click', function() {
            checkPaymentStatus();
        });

        document.getElementById('retryPaymentBtn').addEventListener('click', function() {
            fetch('/profile/timeout/' + checkoutRequestID, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'failed') {
                    // Clear previous session data
                    fetch('/profile/clear-session', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ checkoutRequestID: checkoutRequestID })
                    })
                    .then(() => {
                        // Resend STK push request
                        const retryAmount = '{{ $amount }}';
                        const retryPhone = '{{ $phone }}';
                        const retryAccountReference = '{{ $accountReference }}';
                        const retryTransactionDesc = '{{ $transactionDesc }}';

                        fetch('/profile/resend-stk', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                amount: retryAmount,
                                phone: retryPhone,
                                account_reference: retryAccountReference,
                                transaction_desc: retryTransactionDesc
                            })
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.ResponseCode === '0') {
                                // Update checkoutRequestID with new ID if needed
                                checkoutRequestID = response.CheckoutRequestID;
                                // Redirect to waiting page or handle as needed
                            } else {
                                console.error('Error resending STK:', response.errorMessage);
                            }
                        })
                        .catch(error => {
                            console.error('Error resending STK:', error);
                        });
                    })
                    .catch(error => {
                        console.error('Error clearing session:', error);
                    });
                }
            })
            .catch(error => {
                console.error('Error checking timeout:', error);
            });
        });

        setTimeout(function() {
            fetch('/profile/timeout/' + checkoutRequestID, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'failed') {
                    timeoutMessage.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }, timeoutDuration);
    });
</script>


                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
