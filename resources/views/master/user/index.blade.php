@extends('layouts.app')
@section('title')
    Data User
@endsection
@section('modal-button')
    <button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()"
        href="javascript:void(0)">
        <i class="material-icons-outlined fs-5 me-1">add</i>
        <span>Tambah User</span>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-bottom-2 py-2">
                    <h5 class="modal-title" id="modal-Title"></h5>
                    <a href="javascript:;" id="close" class="primaery-menu-close">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="user-add" name="userForm"
                            autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            {{-- Nama Lengkap --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">person</span>
                                </span>
                                <input type="text" class="form-control" id="nama_user" name="nama_user"
                                    placeholder="Nama Lengkap" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Departemen --}}
                            <div class="input-group mb-1">
                                <label class="input-group-text" for="departemen_id">
                                    <span class="material-icons-outlined">maps_home_work</span>
                                </label>
                                <select class="form-select" id="departemen_id" name="departemen_id">
                                    <option selected disabled>Departemen</option>
                                    @foreach ($departemen as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Email --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">email</span>
                                </span>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="example@gmail.com" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Ponsel --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">call</span>
                                </span>
                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Ponsel" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Alamat --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">location_on</span>
                                </span>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Alamat" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- Button --}}
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <button type="button" id="cancel" class="btn btn-sm btn-secondary px-4">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary px-4" id="btn-save">Simpan</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <x-page-title title="Data User" />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Email</th>
                            <th>Ponsel</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#dep').change(function() {
                var val = $(this).val();
                $('#departemen_id').val(val);
            });

            $("#close").click(function() {
                $(':input', '#user-add').val("");
                $('#userModal').modal('hide');
            });

            $("#cancel").click(function() {
                $(':input', '#user-add').val("");
                $('#userModal').modal('hide');
            });

            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#example2').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('master/user') }}",
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_user',
                        name: 'nama_user'
                    },
                    {
                        data: 'nama_departemen',
                        name: 'departemen_id'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ],
            });

        });

        function add() {
            $('#user-add').trigger("reset");
            $('#modal-Title').html("Form Tambah User");
            $('#userModal').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('user-edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#userModal').modal('show');
                    $('#modal-Title').html("Form Edit User");
                    $('#id').val(res.id);
                    $('#nama_user').val(res.nama_user);
                    $('#no_hp').val(res.no_hp);
                    $('#email').val(res.email);
                    $('#alamat').val(res.alamat);
                    $('#departemen_id').val(res.departemen_id);
                }
            });
        }

        function deleteFunc(id) {
            var id = id;
            swal.fire({
                title: "Yakin ingin menghapus data ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "Hapus!",
                cancelButtonText: "Batal",
                reverseButtons: false
            }).then(function() {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('user-destroy') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        swal.fire("Berhasil!", res.message, "success");
                        var oTable = $('#example2').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            })
            // new swal({
            //     title: "Are you sure?",
            //     text: "You will not be able to recover this imaginary file!",
            //     type: "warning",
            //     showCancelButton: true,
            //     confirmButtonColor: "#DD6B55",
            //     confirmButtonText: "Yes, delete it!",
            //     closeOnConfirm: false
            // }, function(isConfirm) {
            //     if (!isConfirm) return;
            //     $.ajax({
            //         url: "scriptDelete.php",
            //         type: "POST",
            //         data: {
            //             id: 5
            //         },
            //         dataType: "html",
            //         success: function() {
            //             swal("Done!", "It was succesfully deleted!", "success");
            //         },
            //         error: function(xhr, ajaxOptions, thrownError) {
            //             swal("Error deleting!", "Please try again", "error");
            //         }
            //     });
            // });
        }

        $('#user-add').submit(function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('user-add') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire({
                        title: "Berhasil!",
                        icon: "success"
                    });
                    $('#userForm').trigger("reset");
                    $("#userModal").modal('hide');
                    var oTable = $('#example2').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endpush
