
<div class="container">
    <h2>Edit Student</h2>

    <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="fname" class="form-control" value="{{ $student->fname }}">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $student->email }}">
        </div>

        <div class="form-group">
            <label for="date_of_birth">Phone</label>
            <input type="number" name="phone" id="date_of_birth" class="form-control" value="{{ $student->phone}}">
        </div>

        <!-- Add more form fields for other student attributes -->

        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>
</div>

