@extends('layouts.app')

@section('content')
    
     <!-- edit user model -->
     <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit/Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- display error validations --}}
                    <ul id="updateform_errlist"></ul>

                    {{-- <input type="text" id="edit_user_id"> --}}
                    
                    <input type="hidden" id="edit_user_id" class="id form-control">
                   
                    <div class="form-control mb-3">
                        <label for="">Name</label>
                        <input type="text" id="edit_name" class="name form-control">
                    </div>
                    <div class="form-control mb-3">
                        <label for="">Email</label>
                        <input type="text" id="edit_email" class="email form-control">
                    </div>
                    <div class="form-control mb-3">
                        <label for="">Account</label>
                        <input type="text" id="edit_account" class="account_no form-control">
                    </div>
                    <div class="form-control mb-3">
                        <label for="">Amount</label>
                        <input type="text" id="edit_amount" class="amount form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_user">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of edit user modal --}}


     <!-- delete user model -->
     <div class="modal fade" id="deleteusermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    
                    <input type="hidden" id="delete_user_id" class="id form-control">
                    <h3>are you sure you want to delete this user?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_user_btn">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of delete user modal --}}
    
    <div class="container py-5">
        <div class="row">
            <div class="container text-md-center">
                <h2 class="barge bg-primary text-light">
                    COIN MANEGER
                </h2>
            </div>
            
            <div class="col-md-12">
                {{-- the div tag below display the  success message from ajax response --}}
                <div id="success_message"></div>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            User Data
                            {{-- <a href="#" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">Add user</a> --}}
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered  table-striper table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>EMAIL</th>
                                    <th>ACCOUNT NO#</th>
                                    <th>AMOUNT</th>
                                    <th>EDIT</th>
                                    <th>DELETE</th>
                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            fetchUsers()
            //ajax function to get data from the database
            function fetchUsers() {
                $.ajax({
                    type: 'GET',
                    url: '/fetchusers',
                    dataType: 'json',
                    success: function(response) {

                        $('tbody').html(""); //empty the table first
                        // alert(1);
                        // console.log(response.users);
                        $.each(response.users, function(key, item) {
                            $('tbody').append(
                                `<tr>
                                    <td>` + item.id + `</td>
                                    <td>` + item.name + `</td>
                                    <td>` + item.email + `</td>
                                    <td>` + item.account_no + `</td>
                                    <td>` + item.amount + `</td>
                                    <td><button type="button" value="` + item.id + `"
                                            class="edit_user btn btn-primary btn-sm">edit</button></td>
                                    <td><button type="button" value="` + item.id + `"
                                            class="delete_user btn btn-danger btn-sm">delete</button></td>
                                </tr>`
                            );
                        });

                    }
                });
            }

            // an ajax function to delete data from the list
            $(document).on('click', '.delete_user', function(e){
                e.preventDefault();
                    
                var std_id = $(this).val();
                // alert(std_id);
                $('#delete_user_id').val(std_id);
                $('#deleteusermodal').modal('show');

            });
            $(document).on('click', '.delete_user_btn', function(e){
                e.preventDefault();

                $(this).text('deleting');
                var std_id = $('#delete_user_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'delete',
                    url: '/delete-user/'+ std_id,
                    success: function(response){
                        // alert(response)
                        $('#success_message').text(response.message);
                        $('#success_message').addClass('alert alert-success');
                        $('#deleteusermodal').modal('hide');
                        setTimeout(function() {
                            $("#success_message").text("").removeClass();
                            }, 5000);
                            $('.delete_user_btn').text('Yes Delete');

                        fetchUsers();
                    }
                });
                

            });
            //function below edit user by id
            $(document).on('click','.edit_user', function(e) {
                e.preventDefault();
                var std_id  = $(this).val();
                // console.log(std_id);
                // alert(1);
                $('#editUserModal').modal('show');
                //ajax get request to fetch data to be edited
                $.ajax({
                    method: "GET",
                    url: "/edit-user/" + std_id,
                    type: "JSON",
                    success: function(response){
                        // console.log(response);
                        if(response.status == 404){
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        }else{
                            $('#edit_name').val(response.user.name);
                            $('#edit_email').val(response.user.email);
                            $('#edit_account').val(response.user.account_no);
                            $('#edit_amount').val(response.user.amount);
                            $('#edit_user_id').val(std_id);
                        }
                    }

                });
            });

            //update function appear below 
            $(document).on('click', '.update_user', function(e){
                e.preventDefault();
                $(this).text('Updating');
                var std_id = $('#edit_user_id').val();

                var ed_data = {
                    'name':$('#edit_name').val(),
                    'email':$('#edit_email').val(),
                    'account_no':$('#edit_account').val(),
                    'amount':$('#edit_amount').val(),

                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'PUT',
                    url: '/update_user/'+std_id,
                    data: ed_data,
                    dataType:'json',
                    success: function(response){
                        // alert(1);
                        // console.log(response);
                        if(response.status == 400){
                            $('#updateform_errlist').html("");
                            $('#updateform_errlist').addClass('alert alert-danger');
                            $.each(response.error, function(key, err_values) {
                                // console.log(err_values);
                                $('#updateform_errlist').append(`<li>` + err_values +
                                    `</li>`);

                            });
                            $('.update_user').text('Update');

                            setTimeout(function() {
                                $("#updateform_errlist").text("").removeClass();
                            }, 5000);

                        }else if(response.status == 404){
                            $('#updateform_errlist').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);

                        }else{
                            $('#updateform_errlist').html("");
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update_user').text('Update');

                            $('#editUserModal').modal('hide');

                            fetchUsers();

                        }
                    }
                });
            })

                //below function add users to list
            $(document).on('click', '.add_user', function(e) {
                e.preventDefault();
                // alert('tunafika hapa');
                //below variable take data from the input field using jquery
                var data = {
                    'name': $('.name').val(),
                    'email': $('.email').val(),
                    'account_no': $('.account_no').val(),
                    'amount': $('.amount').val()
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // console.log(data)
                $.ajax({
                    type: 'POST',
                    url: '/userstore',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 400) {
                            $('#saveform_errlist').html("");
                            $('#saveform_errlist').addClass('alert alert-danger');
                            $.each(response.error, function(key, err_values) {
                                // console.log(err_values);
                                $('#saveform_errlist').append(`<li>` + err_values +
                                    `</li>`);

                            });
                            setTimeout(function() {
                                $("#saveform_errlist").text("").removeClass();
                            }, 5000);
                        } else {

                            $('#saveform_errlist').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#addUserModal').modal('hide');
                            $('#addUserModal').find('input').val("");
                            fetchUsers();
                            //function to set time out for the success message
                            setTimeout(function() {
                                $("#success_message").text("").removeClass();
                            }, 5000);

                        }
                    }
                });
            });
        });
    </script>
@endsection