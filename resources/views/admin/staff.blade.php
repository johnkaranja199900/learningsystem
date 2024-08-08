@extends('admin.layout')

@section('content')
      <!-- partial -->
  
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                  
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome to Admin Dashboard</h3>
                  <h6 class="font-weight-normal mb-0">Be keen with delete command as you will completelly remove student from the databse</h6>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <form action="{{ route('students') }}" method="get">
                    <input type="text" placeholder="filter fees" name="max_fees" >
                    <button class="btn btn-sm btn-light bg-white" type="submit" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     Filter
                    </button>
                  </form>
                  <form action="{{ route('students') }}" method="get">
                    <div class="input-group">
                      <input type="text"  name="search" id="navbar-search-input" value="{{ $search }}" placeholder="Search student here" aria-label="search" aria-describedby="search">
                    </div>
                  </form>
                  <div>
                    <strong>Sort by:</strong>
                    <a href="{{ route('students', ['sort' => 'asc']) }}">Ascending</a> |
                    <a href="{{ route('students', ['sort' => 'desc']) }}">Descending</a>
                </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          
  
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">List of All Students</p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="example" class="display expandable-table" style="width:100%">
                          <thead>
                            <tr>
                              <th>ID</th>
                               <th>ADM</th>
                              <th>Student name</th>
                              <th>Gender</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>unit</th>
                              <th>paid</th>
                              <th>Edit Actions</th>
                              <th>Delete Actions</th>
                            </tr>
                            <tbody>
                              @foreach($students as $student)
                                  <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->admission_number }}</td>
                                      <td>{{ $student->fname }} {{ $student->sname }} {{ $student->lname }}</td>
                                      <td>{{ $student->gender }}</td>
                                      <td>{{ $student->phone }}</td>
                                      <td>{{ $student->email }}</td>
                                      <td>{{ $student->unit }}</td>
                                      <td>{{ $student->paid }}</td>
                                      <td>
                                          <a class="badge badge-info" href="{{ route('admin.edit', $student->id) }}">Edit</a>
                                        </td>
                                        <td>
                                          <form method="post" action="{{ route('admin.destroy', $student->id) }}">
                                              @csrf
                                              @method('delete')
                                              <button type="submit" class="badge badge-danger">Delete</button>
                                          </form>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                          </thead>
                      </table>
                      <div class="pagination-container">
                        {{ $students->links() }}
                    </div>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>

                
              </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
       
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  @endsection