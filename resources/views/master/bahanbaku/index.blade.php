@extends('layouts.app')
@section('title')
    Data Bahan Baku
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
@endpush
@section('modal-button')
    <button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()"
        href="javascript:void(0)">
        <i class="material-icons-outlined fs-5 me-1">add</i>
        <span>Tambah Bahan Baku</span>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="bahanbakuModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="bahanbaku-add"
                            name="bahanbakuForm" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            {{-- Nama Lengkap --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">view_in_ar</span>
                                </span>
                                <input type="text" class="form-control" id="nama_bahanbaku" name="nama_bahanbaku"
                                    placeholder="Nama Bahan Baku" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Harga --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">paid</span>
                                </span>
                                <input type="text" class="form-control" id="harga" name="harga"
                                    placeholder="Rp. 0.000" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Satuan --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">scale</span>
                                </span>
                                <input type="text" class="form-control" id="satuan" name="satuan"
                                    placeholder="Satuan" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Stok --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">inventory_2</span>
                                </span>
                                <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok"
                                    aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            {{-- Tgl --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">calendar_month</span>
                                </span>
                                <input type="text" class="form-control datepicker" id="tgl_exp" name="tgl_exp"
                                    placeholder="Tanggal" aria-label="Username" aria-describedby="basic-addon1">
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
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Tanggal Expired</th>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script type="text/javascript">
        $(".datepicker").flatpickr();
        $(document).ready(function() {
            $("#close").click(function() {
                $(':input', '#bahanbaku-add').val("");
                $('#bahanbakuModal').modal('hide');
            });

            $("#cancel").click(function() {
                $(':input', '#bahanbaku-add').val("");
                $('#bahanbakuModal').modal('hide');
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
                ajax: "{{ url('master/bahanbaku') }}",
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'foto_bahanbaku',
                        name: 'foto_bahanbaku'
                    },
                    {
                        data: 'nama_bahanbaku',
                        name: 'nama_bahanbaku'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'tgl_exp',
                        name: 'tgl_exp'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '8%',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ],
            });

        });

        function add() {
            $('#bahanbaku-add').trigger("reset");
            $('#tgl_exp').trigger("reset");
            $('#modal-Title').html("Form Tambah Bahan Baku");
            $('#bahanbakuModal').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {

            $.ajax({
                type: "POST",
                url: "{{ url('bahanbaku-edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#bahanbakuModal').modal('show');
                    $('#modal-Title').html("Form Edit User");
                    $('#id').val(res.id);
                    $('#nama_bahanbaku').val(res.nama_bahanbaku);
                    $('#harga').val(res.harga);
                    $('#satuan').val(res.satuan);
                    $('#stok').val(res.stok);
                    $('#tgl_exp').val(res.tgl_exp);
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
                    url: "{{ url('bahanbaku-destroy') }}",
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
        }

        $('#bahanbaku-add').submit(function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('bahanbaku-add') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire({
                        title: "Berhasil!",
                        icon: "success"
                    });
                    $('#bahanbakuForm').trigger("reset");
                    $("#bahanbakuModal").modal('hide');
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
