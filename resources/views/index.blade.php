@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <x-page-title title="Dashboard" subtitle="Analysis" />

    <div class="row">
        <div class="col-xxl-8 d-flex align-items-stretch">
            <div class="card w-100 overflow-hidden rounded-4">
                <div class="card-body position-relative p-4">
                    <div class="row">
                        <div class="col-12 col-sm-7">
                            <div class="d-flex align-items-center gap-3 mb-5">
                                <img src="{{ URL::asset('build/images/users/' . Auth::user()->foto) }}"
                                    class="rounded-circle bg-grd-info p-1" width="60" height="60" alt="user">
                                <div class="">
                                    <p class="mb-0 fw-semibold">Selamat datang kembali,</p>
                                    <h4 class="fw-semibold fs-4 mb-0">{{ Auth::user()->nama_user }}!</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-5">
                                <div class="">
                                    <h4 class="mb-1 fw-semibold d-flex align-content-center">$65.4K<i
                                            class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                                    </h4>
                                    <p class="mb-3">Today's Sales</p>
                                    <div class="progress mb-0" style="height:5px;">
                                        <div class="progress-bar bg-grd-success" role="progressbar" style="width: 60%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="vr"></div>
                                <div class="">
                                    <h4 class="mb-1 fw-semibold d-flex align-content-center">78.4%<i
                                            class="ti ti-arrow-up-right fs-5 lh-base text-success"></i>
                                    </h4>
                                    <p class="mb-3">Growth Rate</p>
                                    <div class="progress mb-0" style="height:5px;">
                                        <div class="progress-bar bg-grd-danger" role="progressbar" style="width: 60%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="welcome-back-img pt-4">
                                <img src="{{ URL::asset('build/images/gallery/welcome-back-3.png') }}" height="180"
                                    alt="">
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-4">
            <div class="card w-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="">
                                <h5 class="mb-0">Order Status</h5>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <span class="material-icons-outlined fs-5">more_vert</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="position-relative">
                            <div class="piechart-legend">
                                <h2 class="mb-1">68%</h2>
                                <h6 class="mb-0">Total Sales</h6>
                            </div>
                            <div id="chart11"></div>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0 d-flex align-items-center gap-2 w-25"><span
                                        class="material-icons-outlined fs-6 text-primary">fiber_manual_record</span>Sales
                                </p>
                                <div class="">
                                    <p class="mb-0">68%</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0 d-flex align-items-center gap-2 w-25"><span
                                        class="material-icons-outlined fs-6 text-danger">fiber_manual_record</span>Product
                                </p>
                                <div class="">
                                    <p class="mb-0">25%</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0 d-flex align-items-center gap-2 w-25"><span
                                        class="material-icons-outlined fs-6 text-success">fiber_manual_record</span>Income
                                </p>
                                <div class="">
                                    <p class="mb-0">14%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-8">
            <div class="card w-100 rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="">
                            <h5 class="mb-0">Sales & Views</h5>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="chart10"></div>
                    <div
                        class="d-flex flex-column flex-lg-row align-items-start justify-content-around border p-3 rounded-4 mt-3 gap-3">
                        <div class="d-flex align-items-center gap-4">
                            <div class="">
                                <p class="mb-0 data-attributes">
                                    <span
                                        data-peity='{ "fill": ["#98ec2d", "rgb(0 0 0 / 12%)"], "innerRadius": 32, "radius": 40 }'>5/7</span>
                                </p>
                            </div>
                            <div class="">
                                <p class="mb-1 fs-6 fw-bold">Monthly</p>
                                <h2 class="mb-0">65,127</h2>
                                <p class="mb-0"><span class="text-success me-2 fw-medium">16.5%</span><span>55.21
                                        USD</span></p>
                            </div>
                        </div>
                        <div class="vr"></div>
                        <div class="d-flex align-items-center gap-4">
                            <div class="">
                                <p class="mb-0 data-attributes">
                                    <span
                                        data-peity='{ "fill": ["#ff6a00", "rgb(0 0 0 / 12%)"], "innerRadius": 32, "radius": 40 }'>5/7</span>
                                </p>
                            </div>
                            <div class="">
                                <p class="mb-1 fs-6 fw-bold">Yearly</p>
                                <h2 class="mb-0">984,246</h2>
                                <p class="mb-0"><span class="text-success me-2 fw-medium">24.9%</span><span>267.35
                                        USD</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
@endsection
@push('script')
    <!--plugins-->
    <script src="{{ URL::asset('build/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/peity/jquery.peity.min.js') }}"></script>
    <script>
        $(".data-attributes span").peity("donut")
    </script>
    <script src="{{ URL::asset('build/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/data-widgets.js') }}"></script>
    <script src="{{ URL::asset('build/js/main.js') }}"></script>
    <script src="{{ URL::asset('build/js/dashboard1.js') }}"></script>
    <script>
        new PerfectScrollbar(".user-list")
    </script>
@endpush
