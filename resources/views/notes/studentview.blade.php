<!-- resources/views/notes/view.blade.php -->
<x-app-layout>
<div class="container">
    <h1>View Note</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $note->title }}</h5>
            <p class="card-text">{{ $note->content }}</p>
            <p class="card-text"><strong>Course:</strong> {{ $note->course->name }}</p>
            @if ($note->pdf_file)
                <p class="card-text"><strong>PDF File:</strong></p>
                <iframe src="{{ asset($note->pdf_file) }}" width="1000px" height="1000px"></iframe>
            @endif
           
        </div>
    </div>
</div>

</x-app-layout>
