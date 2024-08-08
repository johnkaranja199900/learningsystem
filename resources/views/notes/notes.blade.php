@extends('admin.layout')

@section('content')
<div class="container">
    <h1>Notes</h1>
    <a href="{{ route('notes.add') }}" class="btn btn-primary mb-3">Add Notes</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $groupedNotes = $notes->groupBy('course_id'); // Group notes by course_id
    @endphp

    @foreach ($groupedNotes as $courseId => $notesByCourse)
        @php
            $course = $notesByCourse->first()->course; // Get course details from the first note
        @endphp
        <h3 class="my-4">{{ $course->name }}</h3>

        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notesByCourse as $note)
                    <tr>
                        <td>{{ $note->id }}</td>
                        <td>{{ $note->title }}</td>
                        <td>{{ Str::limit($note->content, 100) }}</td>
                        <td>{{ $note->admin->username }}</td>
                        <td>
                            <a href="{{ route('adnotes.view', $note->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('notes.delete', $note->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>
@endsection
