<!-- resources/views/profile/confirmation.blade.php -->
<x-app-layout>
<section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Confirmation</div>
                <div class="card-body">
                    @if($status == 'success')
                        <div class="alert alert-success">
                            Payment was successful! Amount received: {{ $amount }}.
                        </div>
                    @else
                        <div class="alert alert-danger">
                            Payment failed or no money received. Please try again.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</x-app-layout> 
