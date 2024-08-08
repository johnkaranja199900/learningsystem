<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/css.css">

<!-- Favicon -->
<link href="{{ asset('img/petcom logo.png')}}" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Libraries Stylesheet -->
<link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
<link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

<!-- Customized Bootstrap Stylesheet -->
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="{{ asset('css/style.css')}}" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ URL('/')}}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i></i> <img src="img/petcom logo.png " alt="" width="70" height="50"srcset="">PETCOM COLLEGE</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ URL('/')}}" class="nav-item nav-link active">Home</a>
                <a href="{{ URL('about')}}" class="nav-item nav-link">About</a>
                <a href="{{ URL('courses')}}" class="nav-item nav-link">Courses</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Admission</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="{{URL('howto')}}" class="dropdown-item">how to apply </a>
                        <a href="{{ URL('register')}}" class="dropdown-item">online application</a>
                        <a href="img/fees2023.pdf" class="dropdown-item">Fees Stracture</a>
                    </div>
                </div>
                <a href="{{URL('dashboard')}}" class="nav-item nav-link">Student portal</a>
            </div>
            <div>
                <a href="{{ URL('register')}}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
            </div>
            </div>
           
    </nav>




    <div class="log-wrap">
        <div class="login-html">
            <form method="POST" action="{{ route('register') }}">
                <input id="tab-2" type="radio" name="tab" class="sign-up"checked><label for="tab-2" class="tab">Register</label>
                <div class="login-form">    
                @csrf
                <div class="sign-up-htm">
                    <div class="group">
                        <label for="user" class="label">first Name</label>
                        <input id="user" name="fname"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Second Name</label>
                        <input id="user" name="sname"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('sname')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Last Name</label>
                        <input id="user" name="lname"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Gender</label>
                        <select id="gender" name="gender" class="input" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Phone Number</label>
                        <input id="user" name="phone" type="number"   class="input" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="pass" class="label">Email Address</label>
                        <input id="pass" name="email"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Course</label>
                        <select id="user" name="unit" class="input" required>
                            <option value="packages">Computer Packages</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="Web Development">Web Development</option>
                            <option value="C programming">C programming</option>
                            <option value="Python Programming">Python Programming</option>
                            <option value="PhP programming">PhP programming</option>
                        </select>
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" name="password" type="password" class="input" data-type="password" required>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Confirm Password</label>
                        <input id="pass"name="password_confirmation" type="password" class="input" data-type="password" required>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    
                    <div class="group">
                        <input type="submit" class="button" value="Sign Up">
               
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="{{URL('login')}}">
                        <label for="tab-1">Already Student?</a>
                    </div>
                </div>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
        <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js')}}"></script>
    <script src="{{ asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js')}}"></script>
</body>
</html>