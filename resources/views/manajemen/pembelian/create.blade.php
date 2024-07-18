@extends('layouts.app')
@section('title')
    Form Pembelian Bahan Baku
@endsection
@push('css')
    <link href="{{ URL::asset('build/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <x-page-title title="Form Pembelian Bahan Baku" />
    <div class="card">
        <div class="card-body">
            <div class="form-body">
                <form class="row g-3" action="javascript:void(0)" method="POST" id="pembelian-add" name="pembelianForm"
                    autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="nama_supplier" id="nama_supplier">
                    <input type="hidden" name="users_id" id="users_id" value="{{ $users }}">
                    <input type="hidden" name="nama_bahanbaku" id="nama_bahanbaku">
                    <input type="hidden" name="no_po" id="no_po" value="{{ $no_po }}">

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
                        <div class="d-flex fw-bold">
                            <p>Tanggal</p>
                            <p class="mx-4">:</p>
                            <p>{{ date('d-M-Y') }}</p>
                        </div>
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
                                <input type="text" class="form-control" id="harga" name="harga"
                                    aria-label="Username" aria-describedby="basic-addon1" readonly>
                            </div>
                            {{-- Jumlah --}}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <span class="material-icons-outlined">inventory_2</span>
                                </span>
                                <input type="text" class="form-control" id="qty" name="qty"
                                    placeholder="Masukkan jumlah" aria-label="Username" aria-describedby="basic-addon1">
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
                    <div class="d-flex gap-3 justify-content-end">
                        <button class="btn btn-sm btn-secondary px-2">Kembali</button>
                        <button type="submit" class="btn btn-sm btn-primary px-3" id="btn-simpan">Simpan</button>
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

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
                        $('#nama_supplier').val(res[0].nama_supplier)
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
                let subtotal = qty * harga;

                var html = "<tbody>"
                html += "<tr id= 'baris'" + baris + ">"
                html += "<td contenteditable='true' class='bahanbaku_id d-none' id='bahanbaku_id'" + baris +
                    ">" +
                    bahanbaku_id + "</td>"
                html += "<td contenteditable='true' class='nama_bahanbaku' id='nama_bahanbaku'" + baris +
                    ">" +
                    nama_bahanbaku + "</td>"
                html += "<td contenteditable='true' class='supplier_id invisible' id='supplier_id'" + baris +
                    ">" +
                    supplier_id + "</td>"
                html += "<td contenteditable='true' class='nama_supplier invisible' id='nama_supplier'" + baris +
                    ">" +
                    nama_supplier + "</td>"
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
            })

            $(document).on('click', '#hapus', function() {
                let hapus = $(this).data('row')
                $('#' + hapus).remove()
            })

            $(document).on('click', '#btn-simpan', function() {
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
                console.log(supplier_id);
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
                        subtotal: subtotal,
                    },
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            title: "Berhasil!",
                            icon: "success"
                        });
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            })
        })
    </script>
@endpush
