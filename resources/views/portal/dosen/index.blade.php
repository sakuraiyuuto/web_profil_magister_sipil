@extends('portal/layout/main')

@section('title', 'Dosen - Magister Teknik Sipil UNTAN')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>Dosen</h3>
                        </div>

                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a href="{{ url('dosen') }}">Dosen</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--KF INR BANNER DES Wrap End-->
                </div>
            </div>
        </div>
    </div>

    <!--Banner Wrap End-->

    <!--Content Wrap Start-->
    <div class="kf_content_wrap">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        <div class="table-responsive">
                            <table id="tabel_dosen" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>NIP-NIDN</th>
                                        <th>Pangkat-Golongan</th>
                                        <th>Sinta</th>
                                        <th>Web</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dosens as $dosen)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ url($dosen->foto) }}" alt="Image Missing"
                                                    style="width: 100px;"></td>
                                            <td>{{ $dosen->nama }}</td>
                                            <td>{{ $dosen->nip }}</td>
                                            <td>{{ $dosen->pangkat_golongan }}</td>
                                            <td>
                                                @if ($dosen->sinta != '')
                                                    <a href="{{ $dosen->sinta }}" target="_blank">
                                                        <div class="btn btn-primary">
                                                            Link
                                                        </div>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($dosen->url != '')
                                                    <a href="{{ $dosen->url }}" target="_blank">
                                                        <div class="btn btn-primary">
                                                            Link
                                                        </div>
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--KF_BLOG DETAIL_WRAP END-->
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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#tabel_dosen').DataTable();
        });
    </script>
@endsection
