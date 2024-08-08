@extends('admin.layout')

@section('content')



    <div class="content-wrapper">
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">ADD NEW ADMIN</h4>
                <p class="card-description">
                  Create a new school administrators
                </p>
                <form class="forms-sample" method="POST" action="{{ route('addadmin') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Username</label>
                        <input type="text" class="form-control" name="username" id="exampleInputUsername1" placeholder="Username" >
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                      </div>
                  <div class="form-group">
                    <label for="exampleInputUsername2">Phone</label>
                    <input type="number" class="form-control" name="phone" id="exampleInputUsername1" placeholder="Phone" >
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputUsername3">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputUsername1" placeholder="email" >
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail5">Password</label>
                    <input type="text" name="password" class="form-control" id="exampleInputEmail1" placeholder="Password" >
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
                  
                  <button type="submit" class="btn btn-primary mr-2">Add</button>
                  
                </form>
                
              </div>
            </div>
          </div>
          
          
          
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">List Of Available Admin</h4>
                <p class="card-description">
                  You can edit or delete Admins here
                </p>
                <div class="table-responsive">
                <table class="table table-striped">
                    
                    <thead>
                      <tr>
                        <th>
                          Username
                        </th>
                        <th>
                          Email
                        </th>
                        <th>
                          Phone
                        </th>
                        <th>
                            Password
                          </th>
                        <th>
                            update
                        </th>
                        <th>
                            Delete
                        </th>
                        
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <form method="POST" action="{{ route('adminupdate', $admin->id) }}">
                            @csrf
                            @method('PUT')
                      <tr>
                        <td >
                          <input type="text" name="username" class="form-control" id="exampleInputUsername1" value="{{ $admin->username }}">
                      </td>
                      <td >
                        <input type="email" name="email" class="form-control" id="exampleInputUsername1" value="{{ $admin->email}}">
                    </td>
                        <td >
                            <input type="number" name="phone" class="form-control" id="exampleInputUsername1" value="{{ $admin->phone }}">
                        </td>
                        <td class="py-1">
                            <input type="text" name="password" class="form-control" id="exampleInputEmail1" value="">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary mr-2">Update link</button>
                        </td>
                        </form>
                        <td>
                            <form method="POST" action="{{ route('destroyadmin', $admin->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary mr-2">Delete link</button>
                            </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
@endsection
