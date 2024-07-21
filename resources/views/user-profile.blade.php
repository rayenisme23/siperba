@extends('layouts.app')
@section('title')
    User Profile
@endsection
@section('content')
    <x-page-title title="Profil User" />

    <div class="card rounded-4">
        <div class="card-body p-4">
            <div class="position-relative mb-5">
                <img src="{{ URL::asset('build/images/bg-profile.png') }}" class="img-fluid rounded-4 shadow" alt="">
                <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                    <img src="{{ URL::asset('build/images/users/' . $users->foto) }}"
                        class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170"
                        alt="">
                </div>
            </div>
            <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
                <div class="">
                    <h3>{{ $users->nama_user }}</h3>
                    <p>Departemen {{ $users->nama_departemen }}</p>
                    <div class="d-flex">
                        <p class="mb-0 d-flex align-items-center">
                            <small class="material-icons-outlined me-1">
                                email
                            </small>
                            {{ $users->email }}
                        </p>
                        <span class="mx-2">|</span>
                        <p class="mb-0 d-flex align-items-center">
                            <small class="material-icons-outlined me-1">
                                call
                            </small>
                            {{ $users->no_hp }}
                        </p>
                    </div>
                </div>
                <div class="">
                    <div class="dropdown">
                        <button class="d-flex align-items-center btn btn-sm btn-primary dropdown-toggle" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <small class="material-icons-outlined me-1">
                                settings
                            </small>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><button type="button" onClick="edit()" class="dropdown-item" href="javascript:void(0)">Edit
                                    Profil</button></li>
                            <hr class="my-0">
                            <li><button type="button" class="dropdown-item">Ubah Password</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                        <form class="row g-3" action="javascript:void(0)" method="POST" id="editForm" name="userForm"
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
@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>

    <script>
        function edit(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('profile-edit') }}",
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
        $(document).ready(function() {

        });
    </script>
@endpush
