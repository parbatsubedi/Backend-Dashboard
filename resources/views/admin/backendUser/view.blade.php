@extends('admin.layouts.admin_design')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Users</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Admin Users</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        @include('admin.asset.notification.notify')
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title collapse-link">
                        <h5>List of backend users</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" title="Backend user list">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile No.</th>
                                    <th>Role</th>

                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr class="gradeX">
                                    <td>{{ $loop->index + ($users->perPage() * ($users->currentPage() - 1)) + 1 }}</td>
                                    <td>
                                        &nbsp;{{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile_no }}</td>
                                    <td class="center">
                                        @if(!empty($user->roles))
                                            <ul>
                                            @foreach($user->roles as $role)
                                                <li>{{ $role->name }}</li>
                                            @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="center">

                                        @can('Backend user update permission')
                                        <a href="{{ route('backendUser.permission', $user->id) }}" class="btn btn-sm btn-primary m-t-n-xs"><strong>Update permissions</strong></a>
                                        @endcan

                                        @can('Backend user update role')
                                        <a href="{{ route('backendUser.role', $user->id) }}" class="btn btn-sm btn-info m-t-n-xs"><strong>Update Role</strong></a>
                                        @endcan

                                            <br><br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                @can('Backend user reset password')
                                                <form action="{{ route('backendUser.resetPassword') }}" method="post">
                                                    @csrf
                                                    <input id="resetValue" type="hidden" name="admin_id" value="{{ $user->id }}">
                                                    <button href="{{ route('backendUser.role', $user->id) }}" class="reset btn btn-sm btn-danger m-t-n-xs" rel="{{ $user->id }}"><strong>Reset Password</strong></button>
                                                    <button id="resetBtn-{{ $user->id }}" style="display: none" type="submit" href="{{ route('backendUser.role', $user->id) }}"  class="resetBtn btn btn-sm btn-danger m-t-n-xs"><strong>Reset Password</strong></button>
                                                </form>
                                                <!-- Reset Password Pop Up Generation -->
                                                <div class="popup-overlay" id="popupOverlay">
                                                    <div id="popupForm">
                                                        <span id="popupClose">&times;</span>
                                                        <div class="text-center">
                                                            <label style="font-size: 16px;"><strong>Generate New Password</strong></label>
                                                        </div>
                                                        <div class="form-container">
                                                            <form id="resetPasswordForm" action="{{ route('backendUser.resetPassword') }}" method="post">
                                                            @csrf
                                                                <input type="hidden" id="admin_id" name="user_id" readonly>
                                                                <input type="text" style="color: black;" id="output" name="generatedPassword">
                                                                <div class="btn-container">
                                                                    <button id="generatePasswordBtn" class="reset-btn btn btn-sm btn-success m-t-n-xs" onclick="genPassword()"><i class="fas fa-random"></i><strong>Generate</strong></button>
                                                                    <button id="copyPasswordBtn" class="reset-btn btn btn-sm btn-info m-t-n-xs" onclick="copyClipboard()"><i class="far fa-copy"></i><strong>Copy</strong></button>
                                                                </div>
                                                                <input type="range" id="length" min="8" max="15" value="8" oninput="genPassword()">
                                                                <h3 id="length-val">8</h3>
                                                                <div class="btn-container">
                                                                    <button href="{{ route('backendUser.role', $user->id) }}" class="reset-pw btn btn-sm btn-danger m-t-n-xs mt-4" rel="{{ $user->id }}"><strong>Reset Password</strong></button>
                                                                    <button id="resetBtn-{{ $user->id }}" style="display: none" type="submit" href="{{ route('backendUser.role', $user->id) }}"  class="resetBtn btn btn-sm btn-danger m-t-n-xs"><strong>Reset Password</strong></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    @include('admin.asset.css.datatable')
    <link href="{{ asset('admin/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('scripts')

    <!-- Sweet alert -->
    <script src="{{ asset('admin/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        /* Pop up Java-Script */
        $(document).ready(function () {
        $('.reset').on('click', function (e) {
            e.preventDefault();
            let userId = $(this).attr('rel');

            $('#admin_id').val(userId);
            $('#popupOverlay').fadeIn();
            $('#popupForm').fadeIn();
        });

        $('#popupClose').on('click', function () {
            let userId = $(this).attr('rel');
            $('#popupOverlay').fadeOut();
            $('#popupForm').fadeOut();

            $('#admin_id').val('');
        });
    });

    /* Random Strom Password Genration Script */
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!\"$%&/()=?@~`\\.\';:+=^*_-0123456789';
    let output = document.getElementById("output");

    function randomValue(value){
        return Math.floor(Math.random()*value);
    }

    function genPassword(){
        let length = document.getElementById('length').value;
        document.getElementById("length-val").textContent = length;
        let str = '';

        for(let i=0; i<length ; i++){
            let random = randomValue(characters.length);
            str += characters.charAt(random);
        }
        output.value = str;

    }
    function copyClipboard(){
        output.select();
        document.execCommand('copy');
        if (output.value.trim() === '') {
            // Display an error message or perform any other action for empty output
            alert("Nothing to copy! Generate a password first.");
            return;
        }
        output.setAttribute('data-notification', 'Password Copied!');
        const notificationElement = document.createElement('span');
        notificationElement.innerText = 'Password Copied!';
        notificationElement.classList.add('notification');
        output.parentElement.appendChild(notificationElement);

        // Remove the temporary element after 3 seconds
        setTimeout(function () {
            notificationElement.remove();
        }, 1000);
    }

    $('#generatePasswordBtn').on('click', function (e) {
            e.preventDefault();
            genPassword();
    });

    $('#copyPasswordBtn').on('click', function (e) {
            e.preventDefault();
            // copyClipboard();
    });
    
    /* Sweet Alert Notification to confirm resetting of password */
    $('.reset-pw').on('click', function (e) {
        e.preventDefault();
        let userId = $(this).attr('rel');
        swal({
            title: "Are you sure?",
            text: "This user's password will be changed",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, reset password",
            closeOnConfirm: false
        },  function () {
                // var generatedPassword = $('#output').val();
                // alert(generatedPassword);
                // $('#resetPasswordForm').find('input[name="generatedPassword"]').val(generatedPassword);
                // $('#resetBtn-' + userId).trigger('click');
                $('#resetPasswordForm').submit();
                swal.close();

            })
            $('#popupOverlay').hide();
            $('#popupForm').hide();
        });

        /* Deactivate User */
        $(document).ready(function () {
            $('.deactivateBtn').on('click', function (e) {
                e.preventDefault();
                let userId = $(this).attr('rel');

                    swal({
                        title: "Are you sure?",
                        text: "This User will be Deactivated!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Deactivate User",
                        closeOnConfirm: false
                    }, function (confirmed) {
                        if (confirmed) {
                            let redirectionURL = $(e.currentTarget).attr('href');
                            window.location.href = redirectionURL;
                    }
                });
            });
        });
    </script>

    @include('admin.asset.js.datatable')

    <script>
        $(document).ready(function (e) {
            let a = "Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries";
            $('.dataTables_info').text(a);
        });
    </script>
@endsection


