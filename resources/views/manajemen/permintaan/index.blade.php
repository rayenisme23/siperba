@extends('layouts.app')
@section('title')
    Kelola Permintaan Bahan Baku
@endsection
@section('modal-button')
    <button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()"
        href="javascript:void(0)">
        <i class="material-icons-outlined fs-5 me-1">add</i>
        <span>Tambah Permintaan</span>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="permintaanModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="permintaan-add"
                            name="permintaanForm" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="users_id" id="users_id" value="{{ $users }}">
                            {{-- Bahanbaku --}}
                            <div class="input-group mb-1">
                                <label class="input-group-text" for="bahanbaku_id">
                                    <span class="material-icons-outlined">view_in_ar</span>
                                </label>
                                <select class="form-select" id="bahanbaku_id" name="bahanbaku_id">
                                    <option selected disabled>Bahan Baku</option>
                                    @foreach ($bahanbaku as $bb)
                                        <option value="{{ $bb->id }}">{{ $bb->nama_bahanbaku }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Jumlah --}}
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">inventory_2</span>
                                </span>
                                <input type="text" class="form-control" id="qty" name="qty"
                                    placeholder="Jumlah" aria-label="Username" aria-describedby="basic-addon1">
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
    <x-page-title title="Kelola Permintaan" />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peminta</th>
                            <th>Bahan Baku</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
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

            $("#close").click(function() {
                $(':input', '#permintaan-add').val("");
                $('#bahanbaku_id').trigger("reset");
                $('#permintaanModal').modal('hide');
            });

            $("#cancel").click(function() {
                $(':input', '#permintaan-add').val("");
                $('#bahanbaku_id').trigger("reset");
                $('#permintaanModal').modal('hide');
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
                ajax: "{{ url('manajemen/permintaan') }}",
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_user',
                        name: 'users_id'
                    },
                    {
                        data: 'nama_bahanbaku',
                        name: 'bahanbaku_id'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
            $('#permintaan-add').trigger("reset");
            $('#modal-Title').html("Form Pengajuan Bahan Baku");
            $('#permintaanModal').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {

            $.ajax({
                type: "POST",
                url: "{{ url('permintaan-edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#permintaanModal').modal('show');
                    $('#modal-Title').html("Form Edit Permintaan");
                    $('#id').val(res.id);
                    $('#users_id').val(res.users_id);
                    $('#bahanbaku_id').val(res.bahanbaku_id);
                    $('#qty').val(res.qty);
                }
            });
        }

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('permintaan-destroy') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {

                        var oTable = $('#example2').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }

        $('#permintaan-add').submit(function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('permintaan-store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#permintaanForm').trigger("reset");
                    $("#permintaanModal").modal('hide');
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
