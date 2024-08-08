@extends('admin.layout')

@section('content')

<br>
<br>
<div class="col-md-10 grid-margin transparent">
    <br>
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Student summary details</h3>
        @if(Auth::guard('admin')->check())
                <h3>You are logged in as {{ Auth::guard('admin')->user()->username }}</h3>
            @else
                <h3>You are not logged in</h3>
            @endif
        <h6 class="font-weight-normal mb-0">This is the overorll student summary </h6>
      </div>
    <br>
    <hr>
    <br>
      <div class="row">
        <div class="col-md-6 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <h4 class="mb-4">Total number of Students </h4>
              <p class="fs-30 mb-2">{{ $totalStudents }}</p>
              
            </div>
          </div>
        </div>
        
        <div class="col-md-6 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <h4 class="mb-4">Total Fees Paid</h4>
              <p class="fs-30 mb-2">Ksh. {{ number_format($totalFeesPaid) }}</p>
              
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
          <div class="card card-light-danger">
            <div class="card-body">
              <h4 class="mb-4">Remaining balances</h4>
              <p class="fs-30 mb-2">Ksh. {{ number_format( $totalBalanceRemaining) }}</p>
              
            </div>
          </div>
        </div>
        <div class="col-md-6 stretch-card transparent">
          <div class="card card-light-danger">
            <div class="card-body">
              <p class="mb-4">ToTal Fees Payable</p>
              <p class="fs-30 mb-2">Ksh. {{ number_format($totalFees)}}</p>
              
            </div>
          </div>
        </div>
        
      </div>
      <hr>
      <div class="row">
        <div class="col-md-4 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <h4 class="mb-4">No of Package students </h4>
              <p class="fs-30 mb-2">{{ $packages }}</p>
              
            </div>
          </div>
        </div>
        
        <div class="col-md-4 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <h4 class="mb-4">No of Web development students</h4>
              <p class="fs-30 mb-2">{{ $webdevelopment }}</p>
              
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-tale">
              <div class="card-body">
                <h4 class="mb-4">No of Python programming students </h4>
                <p class="fs-30 mb-2">{{ $python }}</p>
                
              </div>
            </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <h4 class="mb-4">No of C programming students </h4>
              <p class="fs-30 mb-2">{{ $cprogramming }}</p>
              
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4 stretch-card transparent">
            <div class="card card-tale">
              <div class="card-body">
                <h4 class="mb-4">No of PhP programming students </h4>
                <p class="fs-30 mb-2">{{ $php }}</p>
                
              </div>
            </div>
          </div>
        
        <div class="col-md-4 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <h4 class="mb-4">No of Graphic Designstudents</h4>
              <p class="fs-30 mb-2">{{ $webdevelopment }}</p>
              
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

    
  


@endsection