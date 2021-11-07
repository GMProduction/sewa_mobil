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
                    <th>Status</th>
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
                        <td>{{$d->status == 1 ? 'Menunggu Diambil' : ($d->status == 2 ? 'Dipinjam' : 'Tersedia')}}</td>
                        <td style="width: 100px;">
                            <div style=" display: flex; flex-direction: column; justify-content: space-between">
                                <button type="button" class="btn btn-success btn-sm" id="editData" data-image="{{$d->image}}" data-keterangan="{{$d->keterangan}}" data-tahun="{{$d->tahun}}"
                                        data-nopol="{{$d->no_pol}}" data-nama="{{$d->nama}}" data-id="{{$d->id}}">Ubah
                                </button>
                                <button type="button" class="btn btn-info btn-sm my-2" data-nama="{{$d->nama}}" data-id="{{$d->id}}" id="detailHarga" style="color: white">Harga</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="hapus('{{$d->id}}', '{{$d->nama}}') ">hapus</button>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
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


            <div class="modal fade" id="modalHarga" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Harga Mobil <span id="titleHarga"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <form id="formHarga" onsubmit="return saveHarga()">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="form-group mb-2">
                                    <label for="durasi">Durasi</label>
                                  <select class="form-select" id="durasi" required name="duration" style="border-radius: 50px; ">
                                      <option value="" selected disabled>Pilih Data</option>
                                      <option value="6">6 Jam</option>
                                      <option value="12">12 Jam</option>
                                      <option value="24">24 Jam</option>
                                  </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" required id="harga" name="harga" style="height: 38px">
                                </div>
                                <div style="display: flex; justify-content: center">
                                    <button class="btn btn-success btn-sm me-2" type="submit">Simpan</button>
                                    <a class="btn btn-info btn-sm" type="submit" style="color: white" onclick="clearField()">Clear</a>
                                </div>
                            </form>
                            <hr>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Durasi / Jam</th>
                                    <th>Harga</th>
                                    <th style="width: 150px">Aksi</th>
                                </tr>
                                </thead>
                                <tbody id="tbHarha">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('script')
    <script>

        var idMobil;
        $(document).ready(function () {

        })

        $(document).on('click', '#detailHarga', function () {
            idMobil = $(this).data('id')
            getHarga(idMobil)
            $('#modalHarga #titleHarga').html($(this).data('nama'))
            $('#modalHarga').modal('show')
        })

        function saveHarga() {
            var title = 'Simpan Harga';
            if ($('#formHarga #id').val()) {
                title = 'Edit Harga';
            }
            saveData(title, 'formHarga', window.location.pathname+'/harga/'+idMobil, afterharga)
            return false;
        }

        function afterharga() {
            clearField()
            getHarga(idMobil)
        }

        function clearField() {
            $('#formHarga #id').val('')
            $('#formHarga #durasi').val('')
            $('#formHarga #harga').val('')
        }

        function getHarga(id){
            fetch(window.location.pathname+'/harga/'+id)
            .then(response => response.json())
            .then(data => {
                var tabel = $('#tbHarha');
                tabel.empty();
                console.log(data)
                if (data['harga'].length > 0){
                    $.each(data['harga'], function (k, v) {
                        tabel.append('<tr>' +
                            '<td>'+parseInt(k+1)+'</td>' +
                            '<td>'+v['duration']+' Jam</td>' +
                            '<td class="text-end">'+v['harga'].toLocaleString()+'</td>' +
                            '<td><a class="btn btn-sm btn-success me-2" id="editHarga" data-harga="'+v['harga']+'" data-duration="'+v['duration']+'" data-id="'+v['id']+'">edit</a>' +
                            '<a class="btn btn-sm btn-danger" id="deleteHarga" data-id="'+v['id']+'" onclick="deleteHarga('+v['id']+', '+v['duration']+', '+v['harga']+')">hapus</a></td>' +
                            '</tr>')
                    })
                }else {
                    tabel.append('<tr>' +
                        '<td colspan="5" class="text-center">Tidak ada data</td>' +
                        '</tr>')
                }
            })
        }

        $(document).on('click', '#editHarga', function () {
            $('#formHarga #id').val($(this).data('id'))
            $('#formHarga #durasi').val($(this).data('duration'))
            $('#formHarga #harga').val($(this).data('harga'))
        })

        $(document).on('click', '#addData, #editData', function () {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #nopol').val($(this).data('nopol'))
            $('#modal #keterangan').val($(this).data('keterangan'))
            $('#modal #tahun').val($(this).data('tahun'))
            $('#dImg').empty();
            if ($(this).data('id')) {
                $('#dImg').html('<img src="' + $(this).data('image') + '" style="height: 100px">')
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

        function deleteHarga(id,jam, harga) {
            deleteData(jam+' jam dengan harga Rp. '+harga.toLocaleString(), window.location.pathname+'/harga/'+idMobil+'/delete?idh='+id, afterharga)
            return false;
        }

        function hapus(id, name) {
            deleteData(name, window.location.pathname+'/'+id+'/delete')
            return false;
        }
    </script>

@endsection
