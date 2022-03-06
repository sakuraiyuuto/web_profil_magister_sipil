@extends('portal/layout/main')

@section('title', 'Informasi Beasiswa - Sarjana Teknik Sipil UNTAN')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>Informasi Beasiswa</h3>
                        </div>
                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a>Informasi Beasiswa</a></li>
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
        <!--ABOUT UNIVERSITY START-->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <?php $x = 0; ?>
                            @foreach ($informasiBeasiswas as $informasiBeasiswa)
                                <?php $x = $x + 1; ?>
                                @if ($loop->iteration % 2 == 1)
                                    <div class="row">
                                @endif
                                <div class="col-md-6">
                                    <!--BLOG 3 WRAP START-->
                                    <div class="blog_3_wrap">
                                        <!--BLOG 3 SIDE BAR START-->
                                        <ul style="z-index : 1" class="blog_3_sidebar">
                                            <li>
                                                <a href="#">
                                                    {{ date('d', strtotime($informasiBeasiswa->release_date)) }}
                                                    <span>
                                                        {{ substr(date('F', strtotime($informasiBeasiswa->release_date)), 0, 3) }}
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!--BLOG 3 SIDE BAR END-->
                                        <!--BLOG 3 DES START-->
                                        <div class="blog_3_des">
                                            <figure>
                                                <img style="height : 20rem; object-fit :cover"
                                                    src="{{ url($informasiBeasiswa->thumbnail) }}" alt="" />
                                                <figcaption><a href="{{ url($informasiBeasiswa->slug) }}"><i
                                                            class="fa fa-search-plus"></i></a>
                                                </figcaption>
                                            </figure>
                                            <h5><a
                                                    href="{{ url($informasiBeasiswa->slug) }}">{{ $informasiBeasiswa->judul }}</a>
                                            </h5>
                                            <li><i class="fa fa-calendar"></i>
                                                {{ date(' Y', strtotime($informasiBeasiswa->release_date)) }}</li>
                                            <p>
                                                @if (strlen(strip_tags($informasiBeasiswa->teks)) > 256)
                                                    {{ str_replace('&nbsp;', '', substr(strip_tags($informasiBeasiswa->teks), 0, 256) . '...') }}
                                                @else
                                                    {{ str_replace('&nbsp;', '', substr(strip_tags($informasiBeasiswa->teks), 0, 256)) }}
                                                @endif
                                            </p>
                                            <a class="readmore" href="{{ url($informasiBeasiswa->slug) }}">
                                                Selengkapnya
                                                <i class="fa fa-long-arrow-right"></i>
                                            </a>
                                        </div>
                                        <!--BLOG 3 DES END-->
                                    </div>
                                    <!--BLOG 3 WRAP END-->
                                </div>
                                @if ($loop->iteration % 2 == 0)
                        </div>
                        @endif
                        @endforeach
                        @if ($x == 1 || $x == 3 || $x == 5)
                    </div>
                    @endif
                    <!--KF_PAGINATION_WRAP START-->
                    <div class="kf_edu_pagination_wrap">
                        <ul class="pagination">
                            <div class="center">
                                <ul class="pagination">
                                    {{ $informasiBeasiswas->links('pagination::default') }}
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>
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
                                        <img class="img-sidebar-info" src="{{ asset($informasiTerbaru->thumbnail) }}"
                                            alt="">
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
    <!--ABOUT UNIVERSITY END-->
    </div>
    <!--Content Wrap End-->
@endsection