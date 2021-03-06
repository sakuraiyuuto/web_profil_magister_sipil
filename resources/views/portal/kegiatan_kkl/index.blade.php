@extends('portal/layout/main')

@section('title', 'Kuliah Kerja Lapangan - Magister Teknik Sipil UNTAN')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>Kuliah Kerja Lapangan</h3>
                        </div>
                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a>Kuliah Kerja Lapangan</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--KF INR BANNER DES Wrap End-->
                </div>
            </div>
        </div>
    </div>

    <!--Content Wrap Start-->
    <div class="kf_content_wrap">
        <section class="event_list_page">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <table id="tabel_pengabdian_kepada_masyarakat" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        No
                                    </th>
                                    <th>Daftar Kuliah Kerja Lapangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengabdianKeMasyarakats as $pengabdianKeMasyarakat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <!--EVENT LIST Wrap Start-->
                                            <div class="kf_event_list_wrap" style="margin :0;border : 1px solid #b6b6b6">
                                                <div class="row" style="height : 10rem">
                                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                                        <!--EVENT LIST THUMB Start-->
                                                        <div class="kf_event_list_thumb">
                                                            <figure style="height : 13rem">
                                                                <img style="height : 15rem; width:100%; object-fit :cover"
                                                                    src="{{ url($pengabdianKeMasyarakat->thumbnail) }}"
                                                                    alt="" />
                                                            </figure>
                                                        </div>
                                                        <!--EVENT LIST THUMB END-->
                                                    </div>

                                                    <div class="col-lg-9 col-md-9 col-sm-9">
                                                        <!--EVENT LIST DES Start-->
                                                        <div class="kf_event_list_des" style="padding: 10px 10px 10px 0;">
                                                            <h4><a
                                                                    href="{{ url($pengabdianKeMasyarakat->slug) }}"><span>{{ $pengabdianKeMasyarakat->judul }}</span></a>
                                                            </h4>
                                                            <ul class="kf_event_list_links">
                                                                <li><a>Pelaku KKL :
                                                                        {{ $pengabdianKeMasyarakat->author }}</a></li><br>
                                                                <li><a>Tahun KKL :
                                                                        {{ $pengabdianKeMasyarakat->tahun }}</a></li>
                                                            </ul>
                                                            <a class="readmore"
                                                                href="{{ url($pengabdianKeMasyarakat->slug) }}">
                                                                Selengkapnya
                                                                <i class="fa fa-long-arrow-right"></i>
                                                            </a>
                                                        </div>
                                                        <!--EVENT LIST DES END-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--EVENT LIST Wrap END-->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!--KF_EDU_SIDEBAR_WRAP START-->
                    <div class="col-md-4">
                        <div class="kf-sidebar">

                            <!--KF_SIDEBAR_SEARCH_WRAP START-->
                            <div class="widget widget-search">
                                <h2>Pencarian</h2>
                                <form action="{{ url('pencarian') }}">
                                    <div class="input-group">
                                        <input type="search" class="form-control" name="search" placeholder="Search">
                                        <span class="input-group-btn"><button type="submit" id="search-submit"
                                                class="btn"><i class="fa fa-search"></i></button></span>
                                    </div><!-- /.input-group -->
                                </form>
                            </div>
                            <!--KF_SIDEBAR_SEARCH_WRAP END-->

                            <!--KF SIDEBAR RECENT POST WRAP START-->
                            <div class="widget widget-recent-posts">
                                <h2>Informasi Terbaru</h2>
                                <ul class="sidebar_rpost_des">
                                    @foreach ($informasiTerbarus as $informasiTerbaru)
                                        <!--LIST ITEM START-->
                                        <li>
                                            <figure>
                                                <img class="img-sidebar-info"
                                                    src="{{ asset($informasiTerbaru->thumbnail) }}" alt="">
                                                <figcaption><a href="{{ url($informasiTerbaru->slug) }}"><i
                                                            class="fa fa-search-plus"></i></a></figcaption>
                                            </figure>
                                            <div class="kode-text">
                                                <h6>
                                                    <a
                                                        href="{{ url($informasiTerbaru->slug) }}">{{ $informasiTerbaru->judul }}</a>
                                                </h6>
                                                <span>
                                                    <i
                                                        class="fa fa-clock-o"></i>{{ date('d M, Y', strtotime($informasiTerbaru->release_date)) }}

                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ url('/informasi_terbaru') }}" style="margin-top : 40px;font-size : 15px"
                                    class="button-pkm">Semua Informasi</a>

                            </div>
                            <!--KF SIDEBAR RECENT POST WRAP END-->



                        </div>
                    </div>
                    <!--KF EDU SIDEBAR WRAP END-->
                </div>
            </div>
        </section>
    </div>
    <!--Content Wrap End-->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#tabel_pengabdian_kepada_masyarakat').DataTable();
        });
    </script>
@endsection
