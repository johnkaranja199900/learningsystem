<!-- resources/views/notes/list.blade.php -->

<x-app-layout>
    <style>
        .notes-container {
    padding: 20px;
}

.notes-header {
    text-align: center;
    margin-bottom: 20px;
}

.notes-message, .notes-empty {
    text-align: center;
    margin-top: 20px;
}

.notes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.notes-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.notes-list-group-item {
    text-decoration: none;
    color: #000;
}

.notes-title {
    font-size: 1.2em;
}

.notes-content {
    font-size: 0.9em;
    color: #555;
}

.notes-course {
    font-size: 0.8em;
    color: #888;
}

    </style>

    <div class="notes-container">
    <h1 class="notes-header">Notes</h1>

    @if(isset($message))
        <div class="alert alert-warning notes-message">
            {{ $message }}
        </div>
    @endif

    @if($notes->isEmpty())
        <p class="notes-empty">No notes available.</p>
    @else
        <div class="notes-grid">
            @foreach ($notes as $note)
                <div class="notes-card">
                    <a href="{{ route('notes.view', $note->id) }}" class="list-group-item list-group-item-action notes-list-group-item">
                        <p class="mb-1 notes-title" style='color:red'>Click to View PDF</p>
                        <h5 class="mb-1 notes-title">{{ $note->title }}</h5>
                        <p class="mb-1 notes-content">{{ Str::limit($note->content, 100) }}</p>
                        <small class="notes-course">Course: {{ $note->course->name }}</small>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>
