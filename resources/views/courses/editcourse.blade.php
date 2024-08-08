@extends('admin.layout')

@section('content')
<div class="container">
    <h2 class="my-4">Edit Course</h2>
    <div class="bg-gray-100 p-4 rounded-md shadow-md mb-4">
        <form action="{{ route('courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="min-w-full bg-white">
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 font-semibold">Course Name</td>
                        <td class="border px-4 py-2">
                            <input type="text" name="name" class="form-input mt-1 block w-full" value="{{ $course->name }}" required>
                            @if ($errors->has('name'))
                                <span class="text-red-500">{{ $errors->first('name') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border px-4 py-2 text-center">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Course
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
@endsection
