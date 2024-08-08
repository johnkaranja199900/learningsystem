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
            <h3>List Of Student Marks </h3> 
            <a href="{{ route('dresults') }}" class="btn btn-primary">Download Student Results</a>

            <br>
            <label for="search">Search:</label>
            <input type="text" name="search" value="{{ $search }}">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="direction" value="{{ $direction }}">

            <label for="unit">Filter by Unit:</label>
                <select name="unit">
                    <option value="" {{ $unitFilter === '' ? 'selected' : '' }}>All</option>
                    <option value="packages" {{ $unitFilter === 'packages' ? 'selected' : '' }}>Packages</option>
                    <option value="Web Development" {{ $unitFilter === 'Web Development' ? 'selected' : '' }}>Web Development</option>
                    <option value="Graphic Design" {{ $unitFilter === 'Graphic Design' ? 'selected' : '' }}>Graphic Design</option>
                    <option value="C programming" {{ $unitFilter === 'C programming' ? 'selected' : '' }}>C programming</option>
                    <option value="Python Programming" {{ $unitFilter === 'Python Programming' ? 'selected' : '' }}>Python Programming</option>
                    <option value="Php Programming" {{ $unitFilter === 'Php programming' ? 'selected' : '' }}>Packages</option>
                    <!-- Add more options for other units if needed -->
                </select>
            
            <label for="sort">Sort by:</label>
            <select name="sort">
                <option value="id" {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
                <option value="fname" {{ $sort === 'fname' ? 'selected' : '' }}>First Name</option>
                <option value="lname" {{ $sort === 'lname' ? 'selected' : '' }}>Last Name</option>
                <!-- Add more options for other columns if needed -->
            </select>
        
            <select name="direction">
                <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Descending</option>
            </select>
        
            <button type="submit">Apply</button>
        </form>
        
        
        <form method="post" action="{{ route('admin.students.update-results') }}">
                        @csrf
                        @method('put')
   
    <table border="1" >
        <thead>
            <tr>
                <th>ADM</th>
                <th>Name</th>
                <th>unit</th>
                <th>Introduction</th>
                <th>Windows</th>
                <th>Word</th>
                <th>Excel</th>
                <th>Access</th>
                <th>PowerPoint</th>
                <th>Publisher</th>
                <th>Pagemaker</th>
                <th>DOS</th>
                <th>Internet</th>
                
            </tr>
        </thead>
        
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->admission_number }}</td>
                    <td>{{ $student->fname }} {{ $student->sname }} {{ $student->lname }}</td>
                    <td>{{ $student->unit }}</td>
                    

                    <!-- Display results and provide input fields for editing -->
                    

                        @if($student->results->isNotEmpty())
                            <!-- If there are results for the student, display them -->
                            @php $result = $student->results->first(); @endphp
                            <td>
                                
                                <input type="number"  name="students[{{ $student->id }}][introduction]" value="{{ $result->introduction }}">
                            </td>
                            <td>
                                
                                <input type="number"name="students[{{ $student->id }}][windows]" value="{{ $result->windows }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][word]" value="{{ $result->word }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][excel]" value="{{ $result->excel }}">
                            </td>
                            <td>
                               
                                <input type="number" name="students[{{ $student->id }}][access]" value="{{ $result->access }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][powerpoint]" value="{{ $result->powerpoint }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][publisher]" value="{{ $result->publisher }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][pagemaker]" value="{{ $result->pagemaker }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][DOS]" value="{{ $result->DOS }}">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][internet]" value="{{ $result->internet }}">
                            </td>
                        @else
                            <!-- If there are no results, display default values or an empty input -->
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][introduction]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][windows]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][word]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][excel]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][access]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][powerpoint]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][publisher]" value="">
                            </td>
                            <td>
                                
                                <input type="number" name="students[{{ $student->id }}][internet]" value="">
                            </td>
                            
                            
                        @endif

                        
                    <input type="hidden" name="students[{{ $student->id }}][id]" value="{{ $student->id }}">
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
     <button class="btn btn-primary mr-2" type="submit">Update All</button>
    </form>
   {{ $students->links() }}
 </div>
@endsection
