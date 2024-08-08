<!-- resources/views/notes/view.blade.php -->

@extends('admin.layout')

@section('content')
<div class="container">
    <h1>View Note</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $note->title }}</h5>
            <p class="card-text">{{ $note->content }}</p>
            <p class="card-text"><strong>Course:</strong> {{ $note->course->name }}</p>
            <p class="card-text"><strong>Admin:</strong> {{ $note->admin->username }}</p>
            @if ($note->pdf_file)
                <p class="card-text"><strong>PDF File:</strong></p>
                <iframe src="{{ asset($note->pdf_file) }}" width="100%" height="600px"></iframe>
            @endif
            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('notes.delete', $note->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
