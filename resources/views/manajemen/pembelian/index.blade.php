@extends('layouts.app')
@section('title')
    Kelola Pembelian Bahan Baku
@endsection
@section('modal-button')
    @if (Auth::user()->hasRole('Pembelian'))
        <button type="button" class="d-flex justify-items-center btn btn-sm btn-primary px-4" onClick="add()"
            href="javascript:void(0)">
            <i class="material-icons-outlined fs-5 me-1">add</i>
            <span>Tambah Pembelian</span>
        </button>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="pembelianModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="pembelian-add"
                            name="pembelianForm" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="nama_supplier" id="nama_supplier">
                            <input type="hidden" name="users_id" id="users_id" value="{{ $users->id }}">
                            <input type="hidden" name="no_po" id="no_po" value="{{ $no_po }}">
                            <input type="hidden" name="nama_bahanbaku" id="nama_bahanbaku">

                            <div class="d-flex justify-content-between px-2">
                                <table class="fw-bold mb-0">
                                    <tr>
                                        <th>
                                            <p>Nama User</p>
                                        </th>
                                        <th>
                                            <p class="mx-4">:</p>
                                        </th>
                                        <th>
                                            <p>{{ $users->nama_user }}</p>
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
                                <div class="d-flex fw-bold">
                                    <p>Tanggal</p>
                                    <p class="mx-4">:</p>
                                    <p>{{ date('d-M-Y') }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div class="col-md-6">
                                    {{-- Supplier --}}
                                    <div class="input-group mb-3 pe-3">
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
                                </div>
                                <div class="col-md-6">
                                    {{-- Harga --}}
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="material-icons-outlined">paid</span>
                                        </span>
                                        <input type="text" class="form-control" id="harga" name="harga"
                                            aria-label="Username" aria-describedby="basic-addon1" readonly>
                                    </div>
                                    {{-- Jumlah --}}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <span class="material-icons-outlined">inventory_2</span>
                                        </span>
                                        <input type="number" class="form-control" id="qty" name="qty"
                                            placeholder="Masukkan jumlah" aria-label="Username"
                                            aria-describedby="basic-addon1">
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
                                            <th>Total</th>
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
                            <button type="submit" class="btn btn-sm btn-primary px-4" id="btn-simpan">Tambah</button>
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
                            <th>NO. PO</th>
                            <th>Pemesan</th>
                            <th>Supplier</th>
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
        function add() {
            $('#pembelian-add').trigger("reset");
            $('#modal-Title').html("Form Pembelian Bahan Baku");
            $('#pembelianModal').modal('show');
            $('#id').val('');
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                editFunc(id);
            });

            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + rupiah;
            }

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
                        data: 'no_po',
                        name: 'no_po'
                    },
                    {
                        data: 'user',
                        render: function(data, type, row, meta) {
                            return data[0].nama_user;
                        }
                    },
                    {
                        data: 'supplier',
                        render: function(data, type, row, meta) {
                            return data[0].nama_supplier;
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data, type, row, meta) {
                            return formatRupiah(data);
                        }
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

            $('#close').click(function() {
                $(':input', '#pembelian-add').val('');
                $('#supplier_id').prop('selectedIndex', 0);
                $('#bahanbaku_id').prop('selectedIndex', 0);
                $('#supplier_id').prop('disabled', false);
                $('#bahanbaku_id').trigger("reset");
                $('#pembelianTable tbody').remove();
                $('#totalRow').remove();
                $('#pembelianModal').modal('hide');
                $('#pembelianTable tbody').empty();
            });

            $('#cancel').click(function() {
                $(':input', '#pembelian-add').val('');
                $('#supplier_id').prop('selectedIndex', 0);
                $('#bahanbaku_id').prop('selectedIndex', 0);
                $('#supplier_id').prop('disabled', false);
                $('#bahanbaku_id').trigger("reset");
                $('#pembelianTable tbody').remove();
                $('#totalRow').remove();
                $('#pembelianModal').modal('hide');
                $('#pembelianTable tbody').empty();
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
                        $('#nama_supplier').val(res[0].nama_supplier);
                        $('#supplier_id').prop('disabled', true);
                    },
                });
            });

            let baris = 0;
            $(document).on('click', '#tambah', function() {
                baris = baris + 1;
                let bahanbaku_id = $('#bahanbaku_id').val();
                let nama_bahanbaku = $('#nama_bahanbaku').val();
                let supplier_id = $('#supplier_id').val();
                let nama_supplier = $('#nama_supplier').val();
                let qty = $('#qty').val();
                let harga = $('#harga').val();
                let total = qty * harga;

                var html = "<tbody>"
                html += "<tr id='baris" + baris + "'>"
                html += "<td contenteditable='true' class='bahanbaku_id d-none' id='bahanbaku_id" + baris +
                    "'>" + bahanbaku_id + "</td>"
                html += "<td contenteditable='true' class='nama_bahanbaku' id='nama_bahanbaku" + baris +
                    "'>" + nama_bahanbaku + "</td>"
                html += "<td contenteditable='true' class='supplier_id d-none' id='supplier_id" + baris +
                    "'>" + supplier_id + "</td>"
                html += "<td contenteditable='true' class='nama_supplier' id='nama_supplier" +
                    baris + "'>" + nama_supplier + "</td>"
                html += "<td contenteditable='true' class='qty' id='qty" + baris + "'>" + qty + "</td>"
                html += "<td contenteditable='true' class='harga' data-value='" + harga + "' id='harga" +
                    baris + "'>" + formatRupiah(
                        harga) +
                    "</td>"
                html += "<td contenteditable='true' class='total' data-value='" + total +
                    "' id='total" + baris + "'>" +
                    formatRupiah(total) + "</td>"
                html += "<td><button class='btn btn-sm btn-danger' id='hapus' data-row='baris" + baris +
                    "'>-</button></td>"
                html += "</tr>"
                html += "</tbody>"

                $('#pembelianTable').append(html)
                $('#qty').val("");

                // Calculate total
                calculateTotal();
            });

            function calculateTotal() {
                let subtotal = 0;

                $('.total').each(function() {
                    subtotal += parseFloat($(this).data('value'));
                });

                // Remove the old total row if exists
                $('#totalRow').remove();

                // Append new total row
                var totalHtml = "<tfoot id='totalRow'>"
                totalHtml += "<tr>"
                totalHtml += "<td colspan='4' class='text-right'>Subtotal:</td>"
                totalHtml += "<td id='subtotal' data-value='" + subtotal + "' >" + formatRupiah(subtotal) + "</td>"
                totalHtml += "<td></td>"
                totalHtml += "</tr>"
                totalHtml += "</tfoot>"

                $('#pembelianTable').append(totalHtml);
            }

            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + rupiah;
            }

            $(document).on('click', '#hapus', function() {
                let rowId = $(this).data('row');
                $('#' + rowId).remove();
                calculateTotal();
            })

            $(document).on('click', '#btn-simpan', function() {
                let no_po = $('#no_po').val();
                let users_id = $('#users_id').val();
                let subtotal = $('#subtotal').data('value');
                let bahanbaku_id = []
                let supplier_id = $('#supplier_id').val();
                let qty = []
                let harga = []
                let total = []

                $('.bahanbaku_id').each(function() {
                    bahanbaku_id.push($(this).text())
                })

                $('.qty').each(function() {
                    qty.push($(this).text())
                })
                $('.harga').each(function() {
                    harga.push($(this).data('value'))
                })
                $('.total').each(function() {
                    total.push($(this).data('value'))
                })

                $.ajax({
                    type: "POST",
                    url: "{{ url('pembelian-simpan') }}",
                    data: {
                        no_po: no_po,
                        users_id: users_id,
                        supplier_id: supplier_id,
                        bahanbaku_id: bahanbaku_id,
                        qty: qty,
                        harga: harga,
                        total: total,
                        subtotal: subtotal,
                    },
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Berhasil!",
                            icon: "success"
                        });
                        $("#pembelianModal").modal('hide');
                        var oTable = $('#example2').dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            })
        })
    </script>
@endpush
