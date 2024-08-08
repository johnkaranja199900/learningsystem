<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Student Dashboard</title>
  
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('css/materialdesignicons1.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/flag-icon.min.css')}}">
  <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- End plugin css for this page -->
  
  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('css/style1.css')}}">
  <!-- End custom styles -->
  
  <link rel="shortcut icon" href="{{asset('img/petcom logo.png')}}" />
  
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: left;
        align-items: center;
        height: 100vh;
    }
    h1 {
        text-align: center;
        color: #333;
    }
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 500px;
       
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }
    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #218838;
    }
  </style>
  
  <script>
    function convertPhoneNumber() {
        const phoneInput = document.getElementById('phone');
        let phoneNumber = phoneInput.value;

        if (phoneNumber.startsWith('0')) {
            phoneNumber = '254' + phoneNumber.substring(1);
        }

        phoneInput.value = phoneNumber;
    }
  </script>
  
</head>
<body>
  <div class="container-scroller">
    <!-- Navbar -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}"><img src="{{asset('img/petcom.png')}}" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}"><img src="{{asset('img/petcom logo.png')}}" alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="bi bi-arrow-bar-down"></span>
        </button>
        <div class="search-field d-none d-xl-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              </div>
              
            </div>
          </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-md-block">
            <!-- Dropdown items -->
          </li>
          
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="{{asset('img/user.png')}}" alt="image">
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
              <div class="p-2">
                <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                
                <!-- Profile link -->
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" :href="route('profile.edit')">
                  <!-- Profile content -->
                </a>
                
                <!-- Logout link -->
                <div role="separator" class="dropdown-divider"></div>
                <h5 class="dropdown-header text-uppercase pl-2 text-dark mt-2">Actions</h5>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" :href="route('logout')">
                    <x-dropdown-link :href="route('logout')"
                      onclick="event.preventDefault();
                                  this.closest('form').submit();">
                      {{ __('Log Out') }}
                    </x-dropdown-link>
                  </a>
                </form>
              </div>
            </div>
          </li>
          <li>
            <!-- Placeholder -->
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas" aria-expanded="false">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- End Navbar -->
    
    <div class="container-fluid page-body-wrapper">
      <!-- Sidebar -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          
          <!-- Dashboard -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          
          <!-- Profile -->
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
              <span class="menu-title">Profile</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('prof')}}">Update details</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{route('profile.update')}}">Change Password</a></li>
              </ul>
            </div>
          </li>
          
          <!-- View Results -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('student.view-marks') }}">
              <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
              <span class="menu-title">View results</span>
            </a>
          </li>
          
          <!-- Pay Fees -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('payment.form') }}">
              <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
              <span class="menu-title">Pay fees</span>
            </a>
          </li>
          
          <!-- Announcements -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('anncouncements') }}">
              <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
              <span class="menu-title">Announcements</span>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- End Sidebar -->
      
      <!-- Payment Form -->
      <div>
        <h1>M-PESA Payment Form</h1>
        <ol style="color:black">
            <li>Enter your Safaricom Mobile Phone Number to pay with below and click Pay</li>
            <li>When prompted, enter MPESA PIN</li>
            <li>Click 'Complete' Button once you receive MPESA confirmation</li>
        </ol>
        <form method="POST" action="{{ route('payment.process') }}">
          @csrf
          <label for="amount">Amount:</label>
          <input type="text" id="amount" name="amount" required><br><br>
          
          <label for="phone">Phone Number:</label>
          <input type="text" id="phone" name="phone"  required><br><br>
          
          <!-- Hidden fields for account reference and transaction description -->
          <input type="hidden" id="account_reference" value='{{Auth::user()->admission_number}}' name="account_reference" required>
          <input type="hidden" id="transaction_desc" value="{{Auth::user()->fname}}" name="transaction_desc" required>
          
          <button type="submit">Pay Now</button>
        </form>
      </div>
      <!-- End Payment Form -->
      
    </div>
    <!-- End page-body-wrapper -->
  </div>
  <!-- End container-scroller -->
  
  <!-- plugins:js -->
  <script src="{{asset('js/vendor.bundle.base.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- Custom js for this page -->
  <script src="{{asset('js/dashboard.js')}}"></script>
  <script src="{{asset('js/off-canvas.js')}}"></script>
  <!-- End custom js for this page -->
  
</body>
</html>
