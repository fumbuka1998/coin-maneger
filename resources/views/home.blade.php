@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header alert alert-primary">
                        {{-- {{ __('Dashboard') }} --}}

                        <div class="row1">
                            <ul>
                                <li>
                                    <h1><i>HELLO</i></h1>
                                    {{ Auth::user()->name }}
                                </li>
                                <li><img src="../../image/user1.png" style="width:4.25rem"></li>
                            </ul>
                        </div>
                        <div class="row2 ">
                            <ul>
                                <li>
                                    <h1>{{ Auth::user()->amount }}</h1>{{ __('Available Balance') }}
                                </li>

                            </ul>
                        </div>
                        <div class="row3">
                            <ul>
                                <li>
                                    <h3>{{ __('Wallet ID') }}</h3>
                                </li>
                                <li>{{ Auth::user()->account_no }}</li>
                            </ul>

                        </div>




                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif


                        <!-- delete report model -->
                        <div class="modal fade" id="deletehistrModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Report</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" id="delete_histr_id" class="id form-control">
                                        <h3>are you sure you want to delete this Report?</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary delete_report_btn">Yes Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end of delete report modal --}}



                        <div class="col-md-12">
                            {{-- the div tag below display the  success message from ajax response --}}
                            {{-- <div id="success_message"></div> --}}

                            <div class="card">
                                <div class="card-header">
                                    <h4>
                                        {{ Auth::user()->name }} {{ __('Scan History') }}
                                        {{-- <a href="#" id="getinfo" class="btn btn-primary float-end btn-sm" value={{ Auth::user()->account_no  }}>get info</a> --}}
                                        
                                    </h4>
                                </div>
                                <div class="card-body">

                                    <table class="table table-bordered  table-striper table-hover">
                                        {{-- <input type="hidden" id="account_no" class="accNo" value="{{ Auth::user()->account_no }}"> --}}
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>ACCOUNT NO</th>
                                                <th>AMOUNT</th>
                                                <th>DATE</th>
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
            </div>
        </div>
    </div>
    </div>
@endsection


@section('scripts2')
    <script>
        $(document).ready(function() {

            
            // alert(2);
            // {{ Auth::user()->account_no }}
            // var account_no = user_reports()->account_no;
            // var account_no = $(this).val();

            //follow up
//             $.ajax({
//     url: '/fetch-data/' + account_no,
//     type: 'GET',
//     success: function(dataList) {
//         // Do something with the retrieved data list
//     },
//     error: function() {
//         // Handle error
//     }
// });
            // alert(1);
            fetchHistory()
            //ajax function to get data from the database
            function fetchHistory() {
                $.ajax({
                    type: 'GET',
                    url: '/fetchReport/',
                    dataType: 'json',
                    success: function(response) {

                        $('tbody').html(""); //empty he table first
                        // alert(1);
                        // console.log(response.user_reports);
                        $.each(response.user_reports, function(key, item) {
                            $('tbody').append(
                                `<tr>
                                        <td>` + item.id + `</td>
                                        <td>` + item.account_no + `</td>
                                        <td>` + item.amount + `</td>
                                        <td>` + item.created_at + `</td>
                                        
                                        <td><button type="button" value="` + item.id + `"
                                                class="delete_history btn btn-danger btn-sm">delete</button></td>
                                    </tr>`
                            );
                        });

                    }
                });
            }

            // an ajax function to delete data from the list
            $(document).on('click', '.delete_history', function(e) {
                e.preventDefault();

                var history_id = $(this).val();
                // alert(history_id);
                $('#delete_histr_id').val(history_id);
                $('#deletehistrModal').modal('show');

            });

            $(document).on('click', '.delete_report_btn', function(e) {
                e.preventDefault();

                $(this).text('deleting');
                var history_id = $('#delete_histr_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'delete',
                    url: '/delete-report/' + history_id,
                    success: function(response) {
                        // alert(response)
                        $('#success_message').text(response.message);
                        $('#success_message').addClass('alert alert-success');
                        $('#deletehistrModal').modal('hide');
                        setTimeout(function() {
                            $("#success_message").text("").removeClass();
                        }, 5000);
                        $('.delete_report_btn').text('Yes Delete');

                        fetchHistory();
                    }
                });


            });

        })
    </script>
@endsection
