@extends('admin/layout/main')

@section('title', 'Layanan Mahasiswa')

@section('container')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Layanan Mahasiswa</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Alert Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('alert'))
            <div class="alert alert-danger">
                {{ session('alert') }}
            </div>
        @endif

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Layanan Mahasiswa</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <a href="{{ url('/admin/layanan_mahasiswa/create') }}" type="button"
                                            class="btn btn-success mb-3">
                                            <i class="fa fa-plus-circle mr-2"></i>Tambah Data
                                        </a>
                                    </div>
                                </div>

                                <table id="tabel_layanan_mahasiswa" class="table table-bordered table-striped mt-2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Thumbnail</th>
                                            <th>Teks</th>
                                            <th>Jadwal Rilis</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($layananMahasiswas as $layananMahasiswa)
                                            <tr id="{{ $layananMahasiswa->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $layananMahasiswa->judul }}</td>
                                                <td><img src="{{ url($layananMahasiswa->thumbnail) }}"
                                                        style="width:100px">
                                                </td>
                                                @if (strlen($layananMahasiswa->teks) > 100)
                                                    <td>
                                                        {{ str_replace('&nbsp;', '', substr(strip_tags($layananMahasiswa->teks), 0, 100) . '...') }}
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ str_replace('&nbsp;', '', substr(strip_tags($layananMahasiswa->teks), 0, 100) . '...') }}
                                                    </td>
                                                @endif
                                                <td>{{ $layananMahasiswa->release_date }}</td>
                                                @if ($layananMahasiswa->deleted_at == '')
                                                    @if ($layananMahasiswa->release_date <= date('Y-m-d'))
                                                        <td>Rilis</td>
                                                    @else
                                                        <td>Belum Rilis</td>
                                                    @endif
                                                @else
                                                    <td>Terhapus</td>
                                                @endif
                                                @if ($layananMahasiswa->deleted_at == '')
                                                    <td>
                                                        <a href="{{ route('layanan_mahasiswa.edit', $layananMahasiswa) }}"
                                                            class="btn btn-warning open-formModalEdit"><i
                                                                class="fa fa-edit"></i> Edit</a>
                                                        <form
                                                            action="{{ route('layanan_mahasiswa.destroy', $layananMahasiswa) }}"
                                                            method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('Apakah anda yakin ingin menghapus data?')"><i
                                                                    class="fa fa-trash"></i> Delete</button>
                                                        </form>
                                                    </td>
                                                @else
                                                    <td>
                                                        <form
                                                            action="{{ url('/admin/layanan_mahasiswa/' . $layananMahasiswa->id . '/restore') }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary"
                                                                onclick="return confirm('Apakah anda yakin ingin mengembalikan data?')"><i
                                                                    class="fas fa-trash-restore"></i> Restore
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ url('/admin/layanan_mahasiswa/' . $layananMahasiswa->id . '/delete') }}"
                                                            method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('Apakah anda yakin ingin menghapus permanen data?')"><i
                                                                    class="fa fa-trash"></i> Delete Permanent
                                                            </button>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--Data Table -->
    <script>
        $(function() {
            $("#tabel_layanan_mahasiswa").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tabel_layanan_mahasiswa_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
