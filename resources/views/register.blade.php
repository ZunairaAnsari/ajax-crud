@extends('layout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Student Data</h3>
                    <ul id="successMessage"></ul>
                    {{-- Add Student Modal --}}
                    <a href="#" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddStudentModal">
                        Register here
                    </a>

                    <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registration Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="saveFormList" id="saveFormList"></ul>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="birthdate" class="form-label">Birthdate</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary add_student">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- End of add student modal --}}

                {{-- Edit student modal --}}
                <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Form</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="updateForm_errorList" id="updateForm_errorList"></ul>
                                <input type="hidden" id="student-id">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" placeholder="Enter your name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" placeholder="name@example.com" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="edit_password" name="password" placeholder="Enter your password">
                                </div>
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Birthdate</label>
                                    <input type="date" class="form-control" id="edit_birthdate" name="birthdate" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary update_student">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End of edit student modal --}}

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 d-flex">
                            <input type="text" id="search" class="form-control" placeholder="Search students...">
                            {{-- <button type="button" class="btn btn-primary" id="searchBtn">Search</button> --}}
                        </div>
                        <div class="col-md-4">
                            <select id="sort_field" class="form-control">
                                <option value="id">Sort by ID</option>
                                <option value="name">Sort by Name</option>
                                <option value="email">Sort by Email</option>
                                <option value="birthdate">Sort by Birthdate</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="sort_direction" class="form-control">
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-secondary-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Birthdate</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="studentTableBody">
                            <!-- Student Data will be loaded here -->
                        </tbody> 
                    </table>
                    <nav>
                        <ul class="pagination" id="paginationLinks"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        fetchStudent();

        function fetchStudent(page = 1) {
            let search = $('#search').val();
            let sortField = $('#sort_field').val();
            let sortDirection = $('#sort_direction').val();

            $.ajax({
                url: "/getStudents",
                type: 'GET',
                data: {
                    search: search,
                    sort_field: sortField,
                    sort_direction: sortDirection,
                    page: page,  // Pagination
                },
                dataType: 'json',
                success: function(response) {
                    $('#studentTableBody').html('');
                    if (response.data.data.length > 0) {
                        $.each(response.data.data, function(key, student) {
                            $('#studentTableBody').append(`
                                <tr>
                                    <td>${student.id}</td>
                                    <td>${student.name}</td>
                                    <td>${student.email}</td>
                                    <td>${student.birthdate}</td>
                                    <td>
                                        <a href="#" class="edit-student btn btn-info btn-sm" data-id="${student.id}">Edit</a>
                                        | 
                                        <a href="#" class="delete-student btn btn-warning btn-sm" data-id="${student.id}">Delete</a>
                                    </td>
                                </tr>
                            `);
                        });

                        // Render pagination
                        renderPagination(response.data);
                    } else {
                        $('#studentTableBody').append('<tr><td colspan="5" class="text-center">No students found.</td></tr>');
                    }
                },
                error: function(error) {
                    console.log('Error fetching students', error);
                }
            });
        }

        function renderPagination(data) {
            $('#paginationLinks').html('');
            for (let page = 1; page <= data.last_page; page++) {
                let activeClass = data.current_page == page ? 'active' : '';
                $('#paginationLinks').append(`
                    <li class="page-item ${activeClass}">
                        <a href="#" class="page-link" data-page="${page}">${page}</a>
                    </li>
                `);
            }
        }

        // Trigger search, sorting, and pagination
        $(document).on('keyup', '#search', function() {
            fetchStudent();
        });

        $(document).on('change', '#sort_field, #sort_direction', function() {
            fetchStudent();
        });

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            let page = $(this).data('page');
            fetchStudent(page);
        });

        $(document).on('click', '.edit-student', function(e) {
            e.preventDefault();
            var studentId = $(this).data('id');

            $.ajax({
                url: "/editStudent/" + studentId,
                type: 'GET',
                success: function(response) {
                    if (response.data) {
                        $('#student-id').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $('#edit_email').val(response.data.email);
                        $('#edit_password').val('');
                        $('#edit_birthdate').val(response.data.birthdate);

                        $('#EditStudentModal').modal('show');
                    } else {
                        console.log('No data received');
                    }
                },
                error: function(error) {
                    console.log('Error fetching student data', error);
                }
            });
        });

        $(document).on('click', '.update_student', function(e) {
            e.preventDefault();

            var studentId = $('#student-id').val();
            var data = {
                'name': $('#edit_name').val(),
                'email': $('#edit_email').val(),
                'password': $('#edit_password').val(),
                'birthdate': $('#edit_birthdate').val()
            };

            $.ajax({
                type: 'PUT',
                url: "/updateStudent/" + studentId,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 200) {
                        $('#EditStudentModal').modal('hide');
                        fetchStudent(); // Refresh the student list
                        $('#successMessage').html('<li>' + response.message + '</li>').addClass('alert alert-success');
                    } else {
                        $('#updateForm_errorList').html('<li>' + response.message + '</li>').addClass('alert alert-danger');
                    }
                },
                error: function(xhr) {
                    console.log('Error updating student', xhr);
                    $('#updateForm_errorList').html('<li>An unexpected error occurred. Please try again.</li>').addClass('alert alert-danger');
                }
            });
        });

        $(document).on('click', '.delete-student', function(e) {
            e.preventDefault();

            var studentId = $(this).data('id');
            if (confirm('Are you sure you want to delete this student?')) {
                $.ajax({
                    url: "/deleteStudent/" + studentId,
                    type: 'DELETE',
                    success: function(response) {
                        if (response.status === 200) {
                            fetchStudent(); // Refresh the student list
                            $('#successMessage').html('<li>' + response.message + '</li>').addClass('alert alert-success');
                        } else {
                            console.log(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log('Error deleting student', xhr);
                        $('#successMessage').html('<li>An error occurred while deleting the student.</li>').addClass('alert alert-danger');
                    }
                });
            }
        });

        $(document).on('click', '.add_student', function(e) {
            e.preventDefault();

            var data = {
                'name': $('#name').val(),
                'email': $('#email').val(),
                'password': $('#password').val(),
                'birthdate': $('#birthdate').val()
            };

            $.ajax({
                url: "/addStudent",
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    $('#saveFormList').html('').removeClass('alert alert-danger');
                    $('#successMessage').html('').removeClass('alert alert-success');

                    if (response.status == 404) {
                        $('#saveFormList').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_values) {
                            $('#saveFormList').append('<li>' + err_values.join(', ') + '</li>');
                        });
                    } else if (response.status == 200) {
                        $('#successMessage').addClass('alert alert-success');
                        $('#successMessage').append('<li>' + response.message + '</li>');
                        $('#AddStudentModal').modal('hide');
                        $('input').val(''); // Clear inputs
                        fetchStudent(); // Refresh the student list
                    }
                },
                error: function(error) {
                    console.log('Error adding student', error);
                    $('#saveFormList').html('An unexpected error occurred. Please try again.').addClass('alert alert-danger');
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

@endsection
