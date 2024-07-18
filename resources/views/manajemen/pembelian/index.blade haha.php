@extends('layouts.app')
@section('title')
Kelola Pembelian Bahan Baku
@endsection
@section('modal-button')
<button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()" href="javascript:void(0)">
    <i class="material-icons-outlined fs-5 me-1">add</i>
    <span>Tambah Pembelian</span>
</button>
<!-- Modal -->
<div class="modal fade" id="pembelianModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    <form class="row g-3" action="javascript:void(0)" method="POST" id="pembelian-add" name="permintaanForm" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="users_id" id="users_id" value="{{ Auth::user()->id }}">
                        {{-- Jumlah --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <p class="mb-0 fw-bold text-center">NO</p>
                            </span>
                            <input type="text" class="form-control" name="no_po" id="no_po" value="{{ $no_po }}" aria-label="Username" aria-describedby="basic-addon1" readonly>
                        </div>
                        {{-- Bahanbaku --}}
                        <div class="input-group mb-3">
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
                        {{-- Supplier --}}
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="supplier_id">
                                <span class="material-icons-outlined">person_3</span>
                            </label>
                            <select class="form-select" id="supplier_id" name="supplier_id">
                                <option selected disabled>Supplier</option>
                                @foreach ($supplier as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Jumlah --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <span class="material-icons-outlined">inventory_2</span>
                            </span>
                            <input type="text" class="form-control" id="qty" name="qty" placeholder="Masukkan jumlah" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        {{-- Harga --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text " id="basic-addon1">
                                <p class="mb-0 fw-bold text-center">Rp.</p>
                            </span>
                            <input type="text" class="form-control" id="harga" name="harga" aria-label="Username" aria-describedby="basic-addon1" placeholder="Harga Bahan Baku" readonly>
                        </div>
                        {{-- Subtotal --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text text-center" id="basic-addon1">
                                <p class="mb-0 fw-bold">Rp.</p>
                            </span>
                            <input type="text" class="form-control" id="subtotal" name="subtotal" aria-label="Username" aria-describedby="basic-addon1" placeholder="Subtotal" readonly>
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
<!-- Detail Modal -->
<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-2 py-2">
                <h5 class="modal-title-detail" id="modal-detail-Title"></h5>
                <a href="javascript:;" id="close" class="primaery-menu-close">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center mb-2">
                    <img class="ms-3" src="{{ URL::asset('build/images/logo-indoneptune.png') }}" width="90" alt="">
                    <div class="ms-2">
                        <p class="mb-0 fw-bold">PT. INDONEPTUNE NET</p>
                        <p class="mb-0 fw-bold">MANUFACTURING</p>
                    </div>
                </div>
                <div class="mb-2">
                    <div class="d-flex">
                        <p class="mb-0">Kepada Yth.</p>
                        <span class="ms-auto">Bandung,</span>
                    </div>
                    <p class="mb-0 fw-bold" id="dt_nama_supplier"></p>
                    <p class="mb-0" id="dt_alamat">Alamat</p>
                    <p class="mb-0" id="dt_no_telp">No. Telp</p>
                </div>
                <div class="text-center mb-3">
                    <span class="mb-0 fw-bold fs-5 text-center text-decoration-underline">PURCHASE ORDER</span><br>
                    <small class="mt-0 fw-bold">NO. PO : <span id="dt_no_po"></span></small>
                </div>

                <table class="table">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">No</th>
                            <th scope="col">Nama Bahan Baku</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga</th>
                            <th scope="col">total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td id="dt_bahanbaku"></td>
                            <td id="qty"></td>
                            <td id="dt_satuan"></td>
                            <td id="dt_harga"></td>
                            <td id="dt_subtotal"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex">
                    <p class="ms-auto fw-bold border pe-4">Subtotal</p>
                    <div class="border mx-3">
                        <p id="dt_subtotal" class="fw-bold ps-2 pe-4">Rp. 32049234</p>
                    </div>
                </div>
                <hr>
                <div class="mb-5">
                    <small class="fw-medium">Kami ucapkan terima kasih atas perhatian dan kerjasamanya.</small><br>
                    <small class="fw-medium">Hormat Kami,</small>
                </div>
                <br><br>
                <div class="col-md-12">
                    <div class="text-center bg-primary p-2 text-white">
                        <small class="mb-0 fw-bold">PT. INDONEPTUNE NET MANUFACTURING</small><br>
                        <small class="mb-0 fw-bold">Jl. Raya Provinsi Bandung - Garut KM. 25 Rancaekek, Kabupaten
                            Bandung 40394 - INDONESIA</small><br>
                        <small class="mb-0 fw-bold">Phone (022) 7798042 - Facs. (022) 7797840, 77903567</small>
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
        </div>
    </div>
</div>
@endsection
@push('css')
<link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<x-page-title title="Kelola Pembelian" />

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="example2" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>Nama Bahan Baku</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
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

        $('#qty').on('input', function() {
            let $harga = $('#harga').val()
            let $qty = $('#qty').val()
            let $subtotal = $harga * $qty
            $('#subtotal').val($subtotal)
        });

        $('#bahanbaku_id').on('change', function() {
            var bahanbaku = $(this).val();
            var price = $(this).parent();
            $.ajax({
                method: 'GET',
                url: "/pembelian-bb/" + bahanbaku,
                dataType: 'json',
                success: function(res) {
                    $('#harga').val(res[0].harga)
                },
            });
        });

        $("#close").click(function() {
            $(':input', '#pembelian-add').val("");
            $('#bahanbaku_id').trigger("reset");
            $('#pembelianModal').modal('hide');
        });

        $("#cancel").click(function() {
            $(':input', '#pembelian-add').val("");
            $('#bahanbaku_id').trigger("reset");
            $('#pembelianModal').modal('hide');
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
            ajax: "{{ url('manajemen/pembelian') }}",
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
                    data: 'nama_supplier',
                    name: 'supplier_id'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'subtotal',
                    name: 'subtotal'
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
        $('#pembelian-add').trigger("reset");
        $('#modal-Title').html("Form Pembelian Bahan Baku");
        $('#pembelianModal').modal('show');
        $('#id').val('');
    }

    function editFunc(id) {

        $.ajax({
            type: "POST",
            url: "{{ url('pembelian-edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('#pembelianModal').modal('show');
                $('#modal-Title').html("Form Edit Pembelian");
                $('#id').val(res.id);
                $('#users_id').val(res.users_id);
                $('#bahanbaku_id').val(res.bahanbaku_id);
                $('#qty').val(res.qty);
            }
        });
    }

    function detailFunc(id) {
        $.ajax({
            type: "POST",
            url: "{{ url('pembelian-detail') }}",
            data: {
                id: id,
            },
            dataType: 'json',
            success: function(res) {
                $('#detailModal').modal('show');
                $('#modal-detail-Title').html("Detail Pembelian");
                $('#id').val(res.id);
                $('#dt_no_po').html(res.no_po);
                $('#dt_nama_supplier').html(res.nama_supplier);
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
                url: "{{ url('pembelian-destroy') }}",
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

    $('#pembelian-add').submit(function(e) {

        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ url('pembelian-store') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $('#pembelianForm').trigger("reset");
                $("#pembelianModal").modal('hide');
                var oTable = $('#example2').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save").attr("disabled", false);
                window.location.reload();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>
@endpush