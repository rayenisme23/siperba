@extends('layouts.app')
@section('title')
    Data Departemen
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('modal-button')
    <button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()"
        href="javascript:void(0)">
        <i class="material-icons-outlined fs-5 me-1">add</i>
        <span>Tambah Departemen</span>
    </button>
@endsection
@section('content')
    <x-page-title title="Data Departemen" />

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Departemen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="departemenModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="departemen-add"
                            name="departemenForm" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            {{-- Departemen --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">maps_home_work</span>
                                </span>
                                <input type="text" class="form-control" id="nama_departemen" name="nama_departemen"
                                    placeholder="Nama Departemen" aria-label="Username" aria-describedby="basic-addon1">
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

            $("#close").click(function() {
                $(':input', '#departemen-departemen').val("");
                $('#departemenModal').modal('hide');
            });

            $("#cancel").click(function() {
                $(':input', '#departemen-departemen').val("");
                $('#departemenModal').modal('hide');
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
                ajax: "{{ url('master/departemen') }}",
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        width: '5%',
                    },
                    {
                        data: 'nama_departemen',
                        name: 'nama_departemen'
                    },
                    {
                        data: 'action',
                        width: '8%',
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
            $('#departemenForm').trigger("reset");
            $('#modal-Title').html("Form Tambah Departemen");
            $('#departemenModal').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {

            $.ajax({
                type: "POST",
                url: "{{ url('departemen-edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#departemenModal').modal('show');
                    $('#modal-Title').html("Form Edit Departemen");
                    $('#id').val(res.id);
                    $('#nama_departemen').val(res.nama_departemen);
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
                    url: "{{ url('departemen-destroy') }}",
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

        $('#departemen-add').submit(function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('departemen-store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    Swal.fire({
                        title: "Berhasil!",
                        icon: "success"
                    });
                    $('#departemen-add').trigger("reset");
                    $("#departemenModal").modal('hide');
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
