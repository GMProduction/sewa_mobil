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
                <h5>Data Master Mobil</h5>
                <button type="button" class="btn btn-primary btn-sm" id="addData">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama / Merk Mobil</th>
                    <th>No. pol</th>
                    <th>Tahun</th>
                    <th>Keterangan</th>

                    <th>Action</th>
                </tr>
                </thead>
                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td><img src="{{$d->image}}" onerror="this.src='{{asset('/images/nouser.png')}}'; this.error=null"
                                 style="height: 100px; object-fit: cover"/>
                        </td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->no_pol}}</td>
                        <td>{{$d->tahun}}</td>
                        <td>{{$d->keterangan}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" id="editData" data-image="{{$d->image}}" data-keterangan="{{$d->keterangan}}" data-tahun="{{$d->tahun}}"
                                    data-nopol="{{$d->no_pol}}" data-nama="{{$d->nama}}" data-id="{{$d->id}}">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data user</td>
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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Master Mobil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form id="form" onsubmit="return save()">

                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="form-group mb-3">
                                    <label for="nama" class="form-label">Nama / Merk Mobil</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" rows="3" name="keterangan"></textarea>
                                </div>


                                <div class="form-group mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" required class="form-control" id="tahun" name="tahun">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nopol" class="form-label">no. Polisi</label>
                                    <input type="text" required class="form-control" id="nopol" name="no_pol">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="image" name="image">
                                    <div id="dImg" class="mt-2"></div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </div>
                        </form>

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

        $(document).on('click', '#addData, #editData', function () {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #nopol').val($(this).data('nopol'))
            $('#modal #keterangan').val($(this).data('keterangan'))
            $('#modal #tahun').val($(this).data('tahun'))
            $('#dImg').empty();
            if ($(this).data('id')){
                $('#dImg').html('<img src="'+$(this).data('image')+'" style="height: 100px">')
            }
            $('#modal').modal('show')
        })

        function save() {
            var title = 'Simpan Data';
            if ($('#form #id').val()) {
                title = 'Edit Data';
            }
            saveData(title, 'form')
            return false
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
