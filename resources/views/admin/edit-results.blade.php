@extends('admin.layout') 

@section('content')
    <h1>Edit Student Results</h1>

    <form method="post" action="{{ route('admin.students.update-results', $user->id) }}">
        @csrf
        @method('put')

        @foreach($results as $result)
            <label for="{{ $result->windows }}">Windows:</label>
            <input type="number" name="results[windows]" value="{{ $result->windows }}">
            <br>
            <!-- Repeat similar lines for other subjects -->
        @endforeach

        <button type="submit">Update Results</button>
    </form>
@endsection
