@extends('admin.layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Students</h1>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Students List
            </div>
            <div class="d-flex gap-2">
                <input type="text" class="form-control" id="searchInput" placeholder="Search by ID/Name">
                <input type="date" class="form-control" id="dateFilter">
            </div>
        </div>
        <div class="card-body">
            <table id="studentsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>PLV ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $student->plv_id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('admin.students.delete', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');
    const table = document.getElementById('studentsTable');
    const rows = table.getElementsByTagName('tr');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const filterDate = dateFilter.value;

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            const id = cells[0].textContent.toLowerCase();
            const name = cells[1].textContent.toLowerCase();
            const date = cells[3].textContent;

            const matchesSearch = id.includes(searchText) || name.includes(searchText);
            const matchesDate = !filterDate || date === filterDate;

            row.style.display = (matchesSearch && matchesDate) ? '' : 'none';
        }
    }

    searchInput.addEventListener('input', filterTable);
    dateFilter.addEventListener('change', filterTable);
});
</script>
@endsection