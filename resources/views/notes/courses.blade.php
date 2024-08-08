<div class="container">
    <h1>Courses</h1>
    <ul class="list-group">
        @foreach ($courses as $course)
            <li class="list-group-item">
                <a class="nav-link" data-toggle="collapse" href="#collapseNotesByCourse{{ $course->id }}" aria-expanded="false" aria-controls="collapseNotesByCourse{{ $course->id }}">
                    View Notes for {{ $course->name }}
                </a>
                <div class="collapse" id="collapseNotesByCourse{{ $course->id }}">
                    <div class="card card-body">
                        <a href="{{ route('notes.bycourse', ['course' => $course->id]) }}" class="btn btn-primary">
                            View Notes for {{ $course->name }}
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
