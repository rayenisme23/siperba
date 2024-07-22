@extends('layouts.app')
@section('title')
    Kelola Permintaan Bahan Baku
@endsection
@section('modal-button')
    @role('Produksi')
        <button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()"
            href="javascript:void(0)">
            <i class="material-icons-outlined fs-5 me-1">add</i>
            <span>Tambah Permintaan</span>
        </button>
    @endrole

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
                            @role('Produksi')
                                {{-- Bahanbaku --}}
                                <div class="form-group mb-1">
                                    <div class="input-group">
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
                                    <div class="error mt-1" id="error_bahanbaku_id"></div>
                                </div>

                                {{-- Jumlah --}}
                                <div class="form-group mb-1">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="material-icons-outlined">inventory_2</span>
                                        </span>
                                        <input type="number" class="form-control" id="qty" name="qty"
                                            placeholder="Jumlah" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="error mt-1" id="error_qty"></div>
                                </div>
                            @endrole
                            @role('Gudang')
                                {{-- Jumlah --}}
                                <div class="form-group mb-1">
                                    <div class="input-group mb-1">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="material-icons-outlined">inventory_2</span>
                                        </span>
                                        <input type="number" class="form-control" id="qty" name="qty"
                                            placeholder="Jumlah" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="error mt-1" id="error_qty"></div>
                                </div>
                            @endrole
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

    <!-- Modal -->
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-bottom-2 py-2">
                    <h5 class="modal-title">Detail Permintaan</h5>
                    <a href="javascript:;" id="dt_close" class="primaery-menu-close">
                        <i class="material-icons-outlined">close</i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="col-md-6">
                            <table>
                                <tr>
                                    <th>Nama</th>
                                    <th class="px-3">:</th>
                                    <th id="dt_nama"></th>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Departemen</td>
                                    <td class="px-3 fw-bold">:</td>
                                    <td class="fw-bold" id="dt_departemen"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="ms-auto">
                                <tr>
                                    <th>Tanggal</th>
                                    <th class="px-3">:</th>
                                    <th id="dt_tanggal"></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped">
                        <tr class="table-primary">
                            <th class="text-center border">No.</th>
                            <th class="text-center border">Nama Bahan Baku</th>
                            <th class="text-center border">Jumlah</th>
                        </tr>
                        <tr>
                            <td class="text-center border">1</td>
                            <td id="dt_bahanbaku"></td>
                            <td class="text-center border" id="dt_jumlah"></td>
                        </tr>
                    </table>

                    <div id="pengurangan">
                        <div class="d-flex justify-content-between fw-bold">
                            <p>Stok bahan baku yang tersedia :</p>
                            <p class="me-5" id="bb_stok"></p>
                        </div>
                        <div class="d-flex justify-content-between fw-bold">
                            <p>Menjadi :</p>
                            <p class="me-5" id="bb_kurang"></p>
                        </div>
                    </div>

                    <div class="d-flex gap-2 fw-bold">
                        <p>Status :</p>
                        <span id="dt_status"></span>
                    </div>

                    <div class="form-body">
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="detail-permintaan"
                            name="detailForm" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="users_id" id="users_id" value="{{ $users }}">

                    </div>
                </div>
                <div class="modal-footer">
                    {{-- Button --}}
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <button type="button" id="print" class="btn btn-sm btn-primary px-5">Print</button>
                            <button type="button" id="tolak" class="btn btn-sm btn-danger px-4">Tolak</button>
                            <button type="button" class="btn btn-sm btn-success px-4" id="terima">Terima</button>
                            <button type="button" class="btn btn-sm btn-secondary px-4" id="kembali">Kembali</button>
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
                $('.error').text('');
            });

            $("#dt_close").click(function() {
                $('#detailModal').modal('hide');
            });

            $("#cancel").click(function() {
                $(':input', '#permintaan-add').val("");
                $('#bahanbaku_id').trigger("reset");
                $('#permintaanModal').modal('hide');
                $('.error').text('');
            });

            $("#kembali").click(function() {
                $('#detailModal').modal('hide');
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
                        render: function(data, type, row, meta) {
                            switch (data) {
                                case 1:
                                    return '<span class="d-block bg-warning text-center py-1 ms-0 rounded fw-medium me-3 text-white">Diproses</span>';
                                case 2:
                                    return '<span class="d-block bg-success text-center py-1 ms-0 rounded fw-medium me-3 text-white">Diterima</span>';
                                case 3:
                                    return '<span class="d-block bg-danger text-center py-1 ms-0 rounded fw-medium me-3 text-white">Ditolak</span>';
                            }
                        }
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
                },
                error: function(xhr) {
                    $('.error').text('');

                    var errors = xhr.responseJSON.errors;

                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('#error_' + key).text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: xhr.responseJSON.error || "Terjadi kesalahan. Silakan coba lagi.",
                            icon: "error"
                        });
                    }
                }
            });
        }

        function detailFunc(id) {

            $.ajax({
                type: "GET",
                url: "{{ url('permintaan-detail') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    var hasil = res.bb_stok - res.qty;
                    console.log(hasil);
                    $('#detailModal').modal('show');
                    $('#id').val(res.id);
                    $('#dt_tanggal').text(res.created_at);
                    $('#dt_jumlah').text(res.qty);
                    $('#dt_nama').text(res.nama_user);
                    $('#dt_bahanbaku').text(res.nama_bahanbaku);
                    $('#dt_departemen').text('Produksi');
                    $('#bb_stok').text(res.bb_stok);
                    $('#bb_kurang').text(hasil);
                    if (res.status == 1) {
                        $('#dt_status').text('Menunggu konfirmasi...');
                        $('#terima').show();
                        $('#tolak').show();
                        $('#kembali').hide();
                        $('#print').hide();
                        $('#pengurangan').show();
                    } else {
                        $('#dt_status').text(res.status == 2 ? 'Telah diterima' : res.status == 3 ?
                            'Permintaan ditolak' : res.status);
                        $('#terima').hide();
                        $('#tolak').hide();
                        $('#kembali').show();
                        $('#print').show();
                        $('#pengurangan').hide();
                    }
                },
                error: function(xhr) {
                    $('.error').text('');

                    var errors = xhr.responseJSON.errors;

                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('#error_' + key).text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: xhr.responseJSON.error || "Terjadi kesalahan. Silakan coba lagi.",
                            icon: "error"
                        });
                    }
                }
            });
        }

        $('#terima').on('click', function() {
            var id = $('#id').val();
            $.ajax({
                type: "POST",
                url: "{{ url('pembelian/terima-po') }}",
                data: {
                    id: id,
                    status: 2
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: res.success,
                            icon: "success"
                        });
                        $('#detailModal').modal('hide');
                        var oTable = $('#example2').dataTable();
                        oTable.fnDraw(false);
                    }
                    if (res.warning) {
                        Swal.fire({
                            title: "Peringatan!",
                            text: res.warning,
                            icon: "warning"
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Gagal!",
                        text: xhr.responseJSON.error || "Terjadi kesalahan. Silakan coba lagi.",
                        icon: "error"
                    });
                }
            });
        });

        $('#tolak').on('click', function() {
            var id = $('#id').val();
            $.ajax({
                type: "POST",
                url: "{{ url('permintaan-tolak') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: res.success,
                            icon: "success"
                        });
                        $('#detailModal').modal('hide');
                        var oTable = $('#example2').dataTable();
                        oTable.fnDraw(false);
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Gagal!",
                        text: xhr.responseJSON.error || "Terjadi kesalahan. Silakan coba lagi.",
                        icon: "error"
                    });
                }
            });
        });

        function deleteFunc(id) {
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
                    url: "{{ url('permintaan-destroy') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        swal.fire("Berhasil!", res.message, "success");
                        var oTable = $('#example2').dataTable();
                        oTable.fnDraw(false);
                        oTable.ajax.reload();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors || {};

                        Swal.fire({
                            title: "Gagal!",
                            text: xhr.responseJSON.error ||
                                'Terjadi kesalahan. Silakan coba lagi.',
                            icon: "error"
                        });
                    }
                });
            })
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
                    Swal.fire({
                        title: "Berhasil!",
                        icon: "success"
                    });
                    $('#permintaanForm').trigger("reset");
                    $("#permintaanModal").modal('hide');
                    var oTable = $('#example2').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                },
                error: function(data) {
                    var errors = data.responseJSON.errors;
                    $('.error').text('');

                    $.each(errors, function(key, value) {
                        $('#error_' + key).text(value[
                            0]);
                    });
                }
            });
        });
    </script>
@endpush
