@extends('layout')

@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Employee Data</h3>
                    <ul id="successMessage"></ul>
                    {{-- Add Employee Modal --}}
                    <a href="#" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal">
                        Register here
                    </a>

                    <div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="AddEmployeeForm" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Registration Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="alert alert-danger d-none" id="save_errorList"></ul>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone #</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image" required>
                                    </div>

                                  
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary add-employee">Save</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body"></div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')

<script src="{{ asset('js/app.js') }}"></script>

@endsection