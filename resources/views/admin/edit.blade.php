@extends('admin.layout')

@section('content')
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
                        
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Student Details</h4>
                  <p class="card-description">
                    Edit all any student details
                  </p>
                  <form class="forms-sample" method="post" action="{{ route('admin.update', $student->id) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="exampleInputFirstName">First Name</label>
                        <input type="text" class="form-control" name="fname" id="exampleInputFirstName" value="{{ $student->fname }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputSecondName">Second Name</label>
                        <input type="text" class="form-control" name="sname" id="exampleInputSecondName" value="{{ $student->sname }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputLastName">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="exampleInputLastName" value="{{ $student->lname }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputGender">Gender</label>
                        <input type="text" class="form-control" name="gender" id="exampleInputGender" value="{{ $student->gender }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="exampleInputPhone" value="{{ $student->phone }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPhone">Unit</label>
                      <input type="text" class="form-control" name="unit" id="exampleInputPhone" value="{{ $student->unit }}">
                  </div>
                    <div class="form-group">
                        <label for="exampleInputPaid">Paid</label>
                        <input type="number" class="form-control" name="paid" id="exampleInputPaid" value="{{ $student->paid }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail" value="{{ $student->email }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
                
                  <br>
                  <button class="btn btn-primary mr-2">
                    <a href="{{route('students')}}"> Cancel</a>
                  </button>
                  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </div>
              </div>
            </div>

          </div>
        </div>
        
        
      </div>
      <!-- main-panel ends -->
    @endsection