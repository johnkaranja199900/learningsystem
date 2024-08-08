@extends('admin.layout') <!-- Adjust the layout as needed -->

@section('content')

<style>
    /* Add custom styles for table */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px; /* Adjust padding as needed */
        text-align: left;
    }

    /* Increase size of the name column */
    th:nth-child(2) {
        width: 20%; /* Adjust width as needed */
    }

    /* Decrease size of other columns */
    th:not(:nth-child(2)), td {
        width: 5%; /* Adjust width as needed */
    }

    /* Adjust input field size */
    input[type="number"] {
        width: 50px; /* Adjust width as needed */
    }
</style>
    <div>
        <form method="get" action="{{ route('admin.view-all-students-marks') }}">
            <br>
            <h3>List Of Student Marks</h3>
            <label for="search">Search:</label>
            <input type="text" name="search" value="{{ $search }}">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">
            
            <label for="sort">Sort by:</label>
            <select name="sort">
                <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                <option value="fname" {{ $sort === 'fname' ? 'selected' : '' }}>First Name</option>
                <option value="lname" {{ $sort === 'lname' ? 'selected' : '' }}>Last Name</option>
                <option value="unit" {{ $sort === 'packages' ? 'selected' : '' }}>packages</option>
                <!-- Add more options for other columns if needed -->
            </select>
        
            <select name="direction">
                <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Descending</option>
            </select>
        
            <button type="submit">Apply</button>
        </form>
        
   
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>unit</th>
                <th>Introduction</th>
                <th>Windows</th>
                <th>Word</th>
                <th>Excel</th>
                <th>Access</th>
                <th>PowerPoint</th>
                <th>Publisher</th>
                <th>Internet</th>
                <th>Edit/Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->fname }} {{ $student->lname }}</td>
                    <td>{{ $student->unit }}</td>

                    <!-- Display results and provide input fields for editing -->
                    <form method="post" action="{{ route('admin.students.update-results', $student->id) }}">
                        @csrf
                        @method('put')

                        @if($student->results->isNotEmpty())
                            <!-- If there are results for the student, display them -->
                            @php $result = $student->results->first(); @endphp
                            <td>
                                <label for="introduction">Introduction:</label>
                                <input type="number" name="results[introduction]" value="{{ $result->introduction }}">
                            </td>
                            <td>
                                <label for="windows">Windows:</label>
                                <input type="number" name="results[windows]" value="{{ $result->windows }}">
                            </td>
                            <td>
                                <label for="word">Word:</label>
                                <input type="number" name="results[word]" value="{{ $result->word }}">
                            </td>
                            <td>
                                <label for="excel">Excel:</label>
                                <input type="number" name="results[excel]" value="{{ $result->excel }}">
                            </td>
                            <td>
                                <label for="access">Access:</label>
                                <input type="number" name="results[access]" value="{{ $result->access }}">
                            </td>
                            <td>
                                <label for="powerpoint">PowerPoint:</label>
                                <input type="number" name="results[powerpoint]" value="{{ $result->powerpoint }}">
                            </td>
                            <td>
                                <label for="publisher">Publisher:</label>
                                <input type="number" name="results[publisher]" value="{{ $result->publisher }}">
                            </td>
                            <td>
                                <label for="internet">Internet:</label>
                                <input type="number" name="results[internet]" value="{{ $result->internet }}">
                            </td>
                        @else
                            <!-- If there are no results, display default values or an empty input -->
                            <td>
                                <label for="introduction">Introduction:</label>
                                <input type="number" name="results[introduction]" value="">
                            </td>
                            <td>
                                <label for="windows">Windows:</label>
                                <input type="number" name="results[windows]" value="">
                            </td>
                            <td>
                                <label for="word">Word:</label>
                                <input type="number" name="results[word]" value="">
                            </td>
                            <td>
                                <label for="excel">Excel:</label>
                                <input type="number" name="results[excel]" value="">
                            </td>
                            <td>
                                <label for="access">Access:</label>
                                <input type="number" name="results[access]" value="">
                            </td>
                            <td>
                                <label for="powerpoint">PowerPoint:</label>
                                <input type="number" name="results[powerpoint]" value="">
                            </td>
                            <td>
                                <label for="publisher">Publisher:</label>
                                <input type="number" name="results[publisher]" value="">
                            </td>
                            <td>
                                <label for="internet">Internet:</label>
                                <input type="number" name="results[internet]" value="">
                            </td>
                            
                            
                        @endif

                        <td>
                            <button type="submit">Update</button>
                        </td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
 </div>
@endsection

