@extends('admin.layout')


@section('content')
<div class="container">
    <h2 class="my-4">Add Course</h2>
    <div class="bg-gray-100 p-4 rounded-md shadow-md mb-4">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <table class="min-w-full bg-white">
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 font-semibold">Course Name</td>
                        <td class="border px-4 py-2">
                            <input type="text" name="name" class="form-input mt-1 block w-full" required>
                            @if ($errors->has('name'))
                                <span class="text-red-500">{{ $errors->first('name') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border px-4 py-2 text-center">
                            <button type="submit" class="btn btn-primary">
                                Add Course
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <h2 class="my-4">Existing Courses</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="border px-4 py-2">Course ID</th>
                <th class="border px-4 py-2">Course Name</th>
                <th class="border px-4 py-2">Edit</th>
                <th class="border px-4 py-2">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td class="border px-4 py-2">{{ $course->id }}</td>
                    <td class="border px-4 py-2">{{ $course->name }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">
                            Edit
                        </a>
                        <td class="border px-4 py-2">
                        <form action="{{ route('courses.delete', $course->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary">
                                Delete
                            </button>
                        </form>
                        </td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection