@extends('admin.layout')

@section('content')



    <div class="content-wrapper">
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">New Meeting Link</h4>
                <p class="card-description">
                  Create a new class link here
                </p>
                <form class="forms-sample" method="POST" action="{{ route('meeting') }}">
                    @csrf
                    <div class="form-group">
                      <label for="user" class="label">Course</label>
                        <select id="user" name="unit" class="form-control" required>
                            <option value="packages">Computer Packages</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="Web Development">Web Development</option>
                            <option value="C programming">C programming</option>
                            <option value="Python Programming">Python Programming</option>
                            <option value="PhP programming">PhP programming</option>
                        </select>
                    </div>
                  <div class="form-group">
                    <label for="exampleInputUsername1">Title</label>
                    <input type="text" class="form-control" name="title" id="exampleInputUsername1" placeholder="class title" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">URL</label>
                    <input type="text" name="url" class="form-control" id="exampleInputEmail1" placeholder="Paste url here" required>
                  </div>
                  
                  <button type="submit" class="btn btn-primary mr-2">Add link</button>
                  
                </form>
                
              </div>
            </div>
          </div>
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">accouncemants</h4>
                <p class="card-description">
                  Enter any accouncements here
                </p>
                <form class="forms-sample" id="announcementForm" method="POST" action="{{ route('addannouncement') }}">
                    @csrf
                  <div class="form-group">
                    <label for="exampleInputUsername1" >Announcements</label>
                    <input type="text" name="message" class="form-control" id="announcementText" required placeholder="Enter announcement">
                  </div>
                  <button type="submit" class="btn btn-primary mr-2" >publish</button>
                  
                </form>
                <div class="mt-3">
                    <h5>Recent Announcement:</h5>
                    @if($latestAnnouncement)
                        <p>{{ $latestAnnouncement->message }}</p>
                    @else
                        <p>No announcements yet.</p>
                    @endif
                </div>
              </div>
            </div>
          </div>
          
          
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">All class Meeting</h4>
                <p class="card-description">
                  You can edit or delete the class meeting here
                </p>
                <div class="table-responsive">
                <table class="table table-striped">
                    
                    <thead>
                      <tr>
                        <th>
                          unit
                        </th>
                        <th>
                          Title
                        </th>
                        <th>
                          Url
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
                        @foreach($meetingLinks as $link)
                        <form method="POST" action="{{ route('admin.meeting-links.update', $link->id) }}">
                            @csrf
                            @method('PUT')
                      <tr>
                        <td >
                          <input type="text" name="title" class="form-control" id="exampleInputUsername1" value="{{ $link->unit }}">
                      </td>
                        <td >
                            <input type="text" name="title" class="form-control" id="exampleInputUsername1" value="{{ $link->title }}">
                        </td>
                        <td class="py-1">
                            <input type="text" name="url" class="form-control" id="exampleInputEmail1" value="{{ $link->url }}">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary mr-2">Update link</button>
                        </td>
                        </form>
                        <td>
                            <form method="POST" action="{{ route('admin.meeting-links.destroy', $link->id) }}">
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
