@extends('admin.layout')

@section('content')
<div class="container">
    <h1>{{ isset($note) ? 'Edit Note' : 'Add Note' }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ isset($note) ? route('notes.update', $note->id) : route('notes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($note))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" class="form-control">
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ isset($note) && $course->id == $note->course_id ? 'selected' : '' }}>{{ $course->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $note->title ?? '') }}">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control">{{ old('content', $note->content ?? '') }}</textarea>
        </div>
        <div class="form-group">
            <label for="pdf_file">PDF File</label>
            <input type="file" name="pdf_file" id="pdf_file" class="form-control">
            @if (isset($note) && $note->pdf_file)
                <p>Current PDF: <a href="{{ url('notes/' . $note->pdf_file) }}" target="_blank">View PDF</a></p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($note) ? 'Update Note' : 'Add Note' }}</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endsection
