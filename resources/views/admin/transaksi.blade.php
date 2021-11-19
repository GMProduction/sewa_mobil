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
                <h5>Data Perkembangan</h5>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Status Sewa</label>
                    <form>
                        <div class="d-flex">
                            <select class="form-select me-2" aria-label="Default select example" id="selectStatus" name="status">
                                <option selected value="">Semua</option>
                                <option value="11">Menunggu Konfirmasi</option>
                                <option value="1">Menunggu Diambil</option>
                                <option value="2">Dipinjam</option>
                                <option value="3">Selesai</option>
                            </select>
                            <button type="submit" class="btn btn-success">Cari</button>
                        </div>
                    </form>

                </div>

            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Mobil</th>
                    <th>Tanggal</th>
                    <th>Durasi</th>
                    <th>Status Sewa</th>
                    <th>Status Pembayaran</th>
                    <th>Action</th>
                </tr>
                </thead>
                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td>{{$d->user->nama}}</td>
                        <td>{{$d->harga->mobil->nama}}</td>
                        <td>{{date('d F Y H:i:s', strtotime($d->tanggal_pinjam))}}</td>
                        <td>{{$d->harga->duration}} Jam</td>
                        <td>{{$d->status == 0 ? 'Menunggu Konfirmasi' : ($d->status == 1 ? 'Menunggu Pengambilan' : ($d->status == 2 ? 'Dipinjam' : 'Selesai'))}}</td>
                        <td>{{$d->status_pembayaran == 0 ? 'Menunggu' : ($d->status_pembayaran == 1 ? 'Ditolak' : 'Diterima')}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" id="detailData" data-id="{{$d->id}}">Detail</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>
        </div>


        <div>

            <!-- Detail-->
            <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detail1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detail1">Detail Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Nama Pelanggan</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dName">Ayu</span></td>
                                        </tr>
                                        <tr class="mb-3">
                                            <th>No. Hp</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dhp">087987984</span></td>
                                        </tr>

                                        <tr class="mb-3">
                                            <th>Alamat</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dAlamat">Jl. jl men</span></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Nama Mobil</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dMobil">Mazda Hijau</span></td>
                                        </tr>
                                        <tr>
                                            <th>Tahun</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dTahun">2021</span></td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dKeterangan">Mobil sedan warna hijau </span></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Tanggal Sewa</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dTanggal">12 September 2021</span></td>
                                        </tr>
                                        <tr class="mb-3">
                                            <th>Durasi</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dDurasi">12 Jam</span></td>
                                        </tr>

                                        <tr class="mb-3">
                                            <th>Biaya</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dBiaya">Rp 200.000</span></td>
                                        </tr>

                                    </table>
                                </div>

                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Bukti Pembayaran</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 mb-1">
                                                    <a id="imgBukti" target="_blank" style="cursor: pointer; " href="">
                                                        <img
                                                            class="mb-1"
                                                            src=""
                                                            width="100"/></a></span>
                                            </td>
                                        </tr>

                                        <tr id="btnKonfir">
                                            <th>Konfirmasi</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3"><a
                                                        class="btn btn-primary btn-sm" onclick="konfirmasiBayar(2)">Terima</a></span>
                                                <span class="ms-1"><a
                                                        class="btn btn-danger btn-sm" onclick="konfirmasiBayar(1)">Tolak</a></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status Bayar</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dStatusBayar">Menunggu Konfirmasi </span></td>
                                        </tr>

                                        <tr>
                                            <th>Status Sewa</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3 field" id="dStatus">Sedang Di pakai </span></td>
                                        </tr>


                                        <div class="mb-4"></div>

                                    </table>

                                </div>

                            </div>

                        </div>
                        <div class="modal-footer" id="btnFooter">

                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal Tambah-->


        </div>

    </section>

@endsection

@section('script')
    <script>
        var idTrans, setStatus;
        $(document).ready(function () {
            $('#selectStatus').val({{request('status')}})
        })

        $(document).on('click', '#detailData', function () {
            idTrans = $(this).data('id');
            setStatus = null;
            featchTransaksi()
            $('#detail').modal('show')
        })

        $('#detail').on('hidden.bs.modal', function () {
            // do something…
            if (setStatus){
                window.location.reload();
            }
        })

        function konfirmasiBayar(status) {

            var data = {
                status,
                '_token': '{{csrf_token()}}'
            };
            var title = 'Menerima';
            if (status === 1) {
                title = 'Menolak'
            }

            saveDataObject(title + ' Bukti Pembayaran', data, window.location.pathname + '/' + idTrans + '/konfirmasi-bayar', featchTransaksi)
            setStatus = 1;

            return false;
        }

        function featchTransaksi() {
            fetch(window.location.pathname + '/' + idTrans)
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    $('.field').empty();
                    $('#dName').html(data['user']['nama'])
                    $('#dhp').html(data['user']['pelanggan']['no_hp'])
                    $('#dAlamat').html(data['user']['pelanggan']['alamat'])
                    $('#dMobil').html(data['harga']['mobil']['nama'])
                    $('#dTahun').html(data['harga']['mobil']['tahun'])
                    $('#dKeterangan').html(data['harga']['mobil']['keterangan'])
                    $('#dTanggal').html(data['tanggal_pinjam'])
                    $('#dDurasi').html(data['harga']['duration'] + ' Jam')
                    $('#dBiaya').html(data['harga']['harga'].toLocaleString())
                    $('#btnKonfir').removeClass('d-none')
                    $('#btnFooter').empty();
                    if (data['status_pembayaran'] === 2) {
                        $('#btnKonfir').addClass('d-none')
                        if (data['status'] === 1) {
                            $('#btnFooter').html('<a class="btn btn-success" onclick="sewa(2)">Diambil</a>')
                        } else if (data['status'] === 2) {
                            $('#btnFooter').html('<a class="btn btn-info" style="color: white" onclick="sewa(3)">Dikembalikan</a>')
                        }
                    }
                    $('#dStatus').html(data['status'] === 0 ? 'Menunggu Konfirmasi' : (data['status'] === 1 ? 'Menunggu Pengambilan' : (data['status'] === 2 ? 'Dipinjam' : 'Selesai')))
                    $('#dStatusBayar').html(data['status_pembayaran'] === 0 ? 'Menunggu' : (data['status_pembayaran'] === 1 ? 'Dotolak' : 'Diterima'))
                    $('#imgBukti').attr('href', '#!')
                    $('#imgBukti img').attr('src', '')
                    if (data['image'] && data['image'] !== '') {
                        $('#imgBukti').attr('href', data['image'])
                        $('#imgBukti img').attr('src', data['image'])
                    }
                })
        }

        function sewa(status) {
            var data = {
                status,
                '_token': '{{csrf_token()}}'
            };
            var title = 'Diambil';
            if (status === 3) {
                title = 'Dikembalikan'
            }
            saveDataObject('Mobil ' + title, data, window.location.pathname + '/' + idTrans + '/sewa', featchTransaksi);
            setStatus = 1;

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
