@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <!-- Main Content -->

    <div class="main-content">
        <section class="section">
            <div class="row mb-3">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card h-100">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h2 class="font-20">Recruiter</h2>
                                            @if ($data['recruiter']>0)
                                            <h2 class="mb-3 font-23">{{ $data['recruiter'] }}</h2>
                                            @else
                                            <h2 class="mb-3 font-23">0</h2>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                           <img src="{{ asset('public/admin/assets/img/banner/1.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card h-100">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h2 class="font-20">Entertainer</h2>
                                            @if ($data['entertainer']>0)
                                            <h2 class="mb-3 font-23">{{ $data['entertainer'] }}</h2>
                                            @else
                                            <h2 class="mb-3 font-23">0</h2>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('public/admin/assets/img/banner/2.png')}}" alt="entertainer pic" height="80px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card h-100">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h2 class="font-20">Venue</h2>
                                            @if ($data['venue']>0)
                                            <h2 class="mb-3 font-23">{{ $data['venue'] }}</h2>
                                            @else
                                            <h2 class="mb-3 font-23">0</h2>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('public/admin/assets/img/banner/3.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
