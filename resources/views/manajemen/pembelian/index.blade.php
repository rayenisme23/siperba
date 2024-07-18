@extends('layouts.app')
@section('title')
Kelola Pembelian Bahan Baku
@endsection
@section('modal-button')
<a href="{{ url('pembelian/create') }}">Tambah</a>
<!-- Modal -->
<div class="modal fade" id="pembelianModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
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
                        <input type="hidden" name="nama_supplier" id="nama_supplier" c>
                        <input type="hidden" name="users_id" id="users_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="nama_bahanbaku" id="nama_bahanbaku">
                        <input type="hidden" name="no_po" id="no_po" value="{{ $no_po }}">
                        <div class="d-flex justify-content-between px-2 mt-4">
                            <table class="fw-bold mb-0">
                                <tr>
                                    <th>
                                        <p>Nama User</p>
                                    </th>
                                    <th>
                                        <p class="mx-4">:</p>
                                    </th>
                                    <th>
                                        <p>{{ Auth::user()->nama_user }}</p>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Nomor PO</p>
                                    </td>
                                    <td>
                                        <p class="mx-4">:</p>
                                    </td>
                                    <td>
                                        <p>{{ $no_po }}</p>
                                    </td>
                                </tr>
                            </table>
                            <table class="fw-bold mb-0">
                                <tr>
                                    <th>
                                        <p>Tanggal</p>
                                    </th>
                                    <th>
                                        <p class="mx-4">:</p>
                                    </th>
                                    <th>
                                        <p>{{ date('Y-m-d') }}</p>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Jam</p>
                                    </td>
                                    <td>
                                        <p class="mx-4">:</p>
                                    </td>
                                    <td>
                                        <p class="text-end">{{ date('H:i:s') }}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <div class="col-md-6">
                                {{-- Bahanbaku --}}
                                <div class="input-group mb-3 pe-3">
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
                                <div class="input-group pe-3">
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
                            </div>
                            <div class="col-md-6">
                                {{-- Harga --}}
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="material-icons-outlined">paid</span>
                                    </span>
                                    <input type="text" class="form-control" id="harga" name="harga" aria-label="Username" aria-describedby="basic-addon1" readonly>
                                </div>
                                {{-- Jumlah --}}
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <span class="material-icons-outlined">inventory_2</span>
                                    </span>
                                    <input type="text" class="form-control" id="qty" name="qty" placeholder="Masukkan jumlah" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-5 justify-content-center align-items-center">
                            <button class="btn btn-sm btn-success px-4" id="tambah">Tambah</button>
                        </div>

                        <div class="border">
                            <table class="table table-striped" id="pembelianTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nama Bahan Baku</th>
                                        <th>Supplier</th>
                                        <th>QTY</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- Button --}}
                <div class="col-md-12">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button type="button" id="cancel" class="btn btn-sm btn-secondary px-4">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary px-4" id="btn-detail">Detail</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-2 py-2">
                <h5 class="modal-title">Detail Pembelian</h5>
                <a href="javascript:;" id="close" class="primaery-menu-close">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="detailTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Bahan Baku</th>
                            <th>Supplier</th>
                            <th>QTY</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                {{-- Button --}}
                <div class="col-md-12">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button type="button" id="kembali" class="btn btn-sm btn-secondary px-4">Kembali</button>
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
        });

    });


    $("#cancelDetail").click(function() {
        $('#pembelianModal').modal('show');
        $('#detailModal').modal('hide');
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
            url: "{{ url('permintaan-edit') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('#pembelianModal').modal('show');
                $('#modal-Title').html("Form Edit Permintaan");
                $('#id').val(res.id);
                $('#qty').val(res.qty);
                $('#no_hp').val(res.no_hp);
                $('#email').val(res.email);
                $('#alamat').val(res.alamat);
                $('#departemen_id').val(res.departemen_id);
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

    $('#bahanbaku_id').on('change', function() {
        var bahanbaku = $(this).val();
        var price = $(this).parent();
        $.ajax({
            method: 'GET',
            url: "/pembelian-bb/" + bahanbaku,
            dataType: 'json',
            success: function(res) {
                $('#harga').val(res[0].harga)
                $('#nama_bahanbaku').val(res[0].nama_bahanbaku)
            },
        });
    });

    $('#supplier_id').on('change', function() {
        var supplier = $(this).val();
        var data = $(this).parent();
        $.ajax({
            method: 'GET',
            url: "/pembelian-supp/" + supplier,
            dataType: 'json',
            success: function(res) {
                $('#nama_supplier').val(res[0].nama_supplier)
            },
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        let baris = 0;

        $(document).on('click', '#kembali', function() {
            $('#detailModal').modal('hide')
            $('#detailTable').trigger("reset");
            $('#pembelianModal').modal('show')
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#tambah', function() {
            baris = baris + 1;
            let bahanbaku_id = $('#bahanbaku_id').val();
            let supplier_id = $('#supplier_id').val();
            let qty = $('#qty').val();
            let harga = $('#harga').val();
            let subtotal = qty * harga;

            var html = "<tbody>"
            html += "<tr id= 'baris'" + baris + ">"
            html += "<td contenteditable='true' class='bahanbaku_id' id='bahanbaku_id'" + baris + ">" +
                bahanbaku_id + "</td>"
            html += "<td contenteditable='true' class='supplier_id' id='supplier_id'" + baris + ">" +
                supplier_id + "</td>"
            html += "<td contenteditable='true' class='qty' id='qty'" + baris + ">" + qty + "</td>"
            html += "<td contenteditable='true' class='harga' id='harga'" + baris + ">" + harga +
                "</td>"
            html += "<td contenteditable='true' class='subtotal' id='subtotal'" + baris + ">" +
                subtotal + "</td>"
            html += "<td><button class='btn btn-sm btn-danger' id='hapus' data-row='baris'" + baris +
                ">-</button></td>"
            html += " </tr>"
            html += " </tbody"

            $('#pembelianTable').append(html)
            $('#qty').val("");

            $(document).on('click', '#btn-detail', function() {
                $('#detailTable').append(html)
                $('#pembelianModal').modal('hide')
                $('#detailModal').modal('show')
            })

        })

        $(document).on('click', '#hapus', function() {
            let hapus = $(this).data('row')
            $('#' + hapus).remove()
        })

        $(document).on('click', '#btn-save', function() {
            let no_po = $('#no_po').val();
            let users_id = $('#users_id').val();
            let bahanbaku_id = []
            let supplier_id = []
            let qty = []
            let harga = []
            let subtotal = []

            $('.bahanbaku_id').each(function() {
                bahanbaku_id.push($(this).text())
            })
            $('.supplier_id').each(function() {
                supplier_id.push($(this).text())
            })
            $('.qty').each(function() {
                qty.push($(this).text())
            })
            $('.harga').each(function() {
                harga.push($(this).text())
            })
            $('.subtotal').each(function() {
                subtotal.push($(this).text())
            })
            console.log(subtotal);
            $('#detailModal').modal('show');
            $('#pembelianModal').modal('hide');


            // $.ajax({
            //     type: "POST",
            //     url: "{{ url('pembelian-simpan') }}",
            //     data: {
            //         no_po: no_po,
            //         users_id: users_id,
            //         supplier_id: supplier_id,
            //         bahanbaku_id: bahanbaku_id,
            //         qty: qty,
            //         harga: harga,
            //         subtotal: subtotal,
            //     },
            //     dataType: 'json',
            //     success: function(res) {
            //         $('#pembelianModal').modal('hide');

            //     },
            //     error: function(err) {
            //         console.log(err);
            //     }
            // });
        })
    })
</script>
@endpush