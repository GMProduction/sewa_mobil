@extends('admin.base')

@section('title')
    Data Siswa
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
        </script>
    @endif

    <section class="m-2">


        <div class="table-container">


            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Data User</h5>
{{--                <button type="button ms-auto" class="btn btn-primary btn-sm" data-bs-toggle="modal"--}}
{{--                        data-bs-target="#tambahsiswa">Tambah Data--}}
{{--                </button>--}}
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Foto Ktp</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                @forelse($data as $key => $d)
                    <tr>
                        <td width="10">{{$data->firstItem() + $key}}</td>
                        <td width="100">
                            <img src="{{$d->pelanggan->avatar}}" onerror="this.src='{{asset('/images/nouser.png')}}'; this.error=null"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->pelanggan->alamat}}</td>
                        <td>{{$d->pelanggan->no_hp}}</td>
                        <td width="100">
                            <img src="{{$d->pelanggan->foto_ktp}}" onerror="this.src='{{asset('/images/noimage.png')}}'; this.error=null"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td width="100"><span class="badge {{$d->pelanggan->isActive === 0 ? 'bg-danger' : 'bg-success'}}">{{$d->pelanggan->isActive === 0 ? 'Tidak Aktif' : 'Aktif'}}</span></td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" data-active="{{$d->pelanggan->isActive}}" data-username="{{$d->username}}"
                                    data-avatar="{{$d->pelanggan->avatar ?? '/images/nouser.png'}}"
                                    data-foto="{{$d->pelanggan->foto_ktp ?? '/images/noimage.png'}}" data-ktp="{{$d->pelanggan->no_ktp}}" data-hp="{{$d->pelanggan->no_hp}}"
                                    data-alamat="{{$d->pelanggan->alamat}}"
                                    data-nama="{{$d->nama}}" data-id="{{$d->id}}" id="detailData">Detail
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data user</td>
                    </tr>
                @endforelse

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>
        </div>


        <div>


            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detaim Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-3">
                                        <div id="" class="d-flex justify-content-center"><img src="" id="imgAvatar" style="height: 100px" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="" for="exampleInputPassword1">Username</label>
                                        <input class="form-control" id="username" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="" for="exampleInputPassword1">Nama</label>
                                        <input class="form-control" id="nama" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="" for="exampleInputPassword1">No. Hp</label>
                                        <input class="form-control" id="hp" disabled>
                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group mb-3">
                                        <div id="" class="d-flex justify-content-center"><img src="" id="imgKtp" style="height: 100px" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="" for="exampleInputPassword1">No. KTP</label>
                                        <input class="form-control" id="ktp" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="" for="exampleInputPassword1">Alamat</label>
                                        <input class="form-control" id="alamat" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <form id="form" onsubmit="return save()">
                                <input type="hidden" name="id" id="id">
                                @csrf
                                <input type="hidden" name="isActive" id="isActive">
                                <button type="submit" id="btnActiv" class="btn btn-success"></button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

        })

        $(document).on('click', '#detailData', function () {
            $('#modal #id').val($(this).data('id'))
            var isActive = $(this).data('active') === 0 ? 1 : 0;
            var btnAktif = $('#btnActiv');
            btnAktif.html('Aktifkan Member').removeClass('btn-danger').addClass('btn-success')
            if(isActive === 0){
                btnAktif.html('Non Aktifkan Member').addClass('btn-danger').removeClass('btn-success')

            }
            $('#modal #isActive').val(isActive)
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #username').val($(this).data('username'))
            $('#modal #ktp').val($(this).data('ktp'))
            $('#modal #hp').val($(this).data('hp'))
            $('#modal #alamat').val($(this).data('alamat'))
            $('#modal #imgAvatar').attr('src', $(this).data('avatar'))
            $('#modal #imgKTP').attr('src', $(this).data('foto'))
            $('#modal').modal('show')
        })

        function save() {
            var title = 'Aktifkan Member';
            if ($('#form #isActive').val() === '0'){
                title = 'Non Aktifkan Member';
            }
            saveData(title,'form')
            return false;
        }

        function hapus(id, name) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Menghapus data!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
