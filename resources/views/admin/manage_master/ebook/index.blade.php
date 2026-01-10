@extends('master')
@section('title', 'Data Ebook')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Ebook</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Data Ebook</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Data Ebook</h2>
                <p class="section-lead">Berikut adalah Data Ebook.</p>
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Data Seluruh Ebook</h4>
                        <div class="card-header-form">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                                Tambah Ebook
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped mt-5">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Foto</th>
                                    <th>File</th>
                                    <th width="10px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Ebook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('admin/manage-master/ebook') }}" method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul Ebook</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penulis</label>
                                    <input type="text" class="form-control" name="author" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ISBN</label>
                                    <input type="text" class="form-control" name="isbn">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control rupiah" name="price_mask" required>
                                    <input type="hidden" name="price" class="raw_price">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" name="stock" required min="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jumlah Halaman</label>
                                    <input type="number" class="form-control" name="total_pages">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Format File</label>
                                    <select class="form-control" name="file_format" required>
                                        <option value="pdf">PDF</option>
                                        <option value="epub">EPUB</option>
                                        <option value="mobi">MOBI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Upload File (Ebook PDF)</label>
                                    <input type="file" class="form-control" name="file" accept=".pdf,.epub,.mobi" required>
                                    <small class="text-muted">Pilih file e-book sesuai format.</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <circle-check-icon></circle-check-icon>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto Sampul (Multiple)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="photos[]" multiple accept="image/*" id="photos_add">
                                <label class="custom-file-label">Pilih Gambar</label>
                            </div>
                            <div id="preview-add" class="mt-2 d-flex flex-wrap"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Ebook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('admin/manage-master/ebook/update') }}" method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id_update">
                    <input type="hidden" name="deleted_photos" id="deleted_photos">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul Ebook</label>
                                    <input type="text" class="form-control" name="title" id="title_update" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <circle-check-icon></circle-check-icon>
                                    <select class="form-control" name="category_id" id="category_id_update" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penulis</label>
                                    <input type="text" class="form-control" name="author" id="author_update" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ISBN</label>
                                    <input type="text" class="form-control" name="isbn" id="isbn_update">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control rupiah" id="price_mask_update" required>
                                    <input type="hidden" name="price" id="price_update" class="raw_price">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" class="form-control" name="stock" id="stock_update" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jumlah Halaman</label>
                                    <input type="number" class="form-control" name="total_pages" id="total_pages_update">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Format File</label>
                                    <select class="form-control" name="file_format" id="file_format_update" required>
                                        <option value="pdf">PDF</option>
                                        <option value="epub">EPUB</option>
                                        <option value="mobi">MOBI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ganti File Ebook (Opsional)</label>
                                    <input type="file" class="form-control" name="file" accept=".pdf,.epub,.mobi">
                                    <small class="text-info" id="current_file_info"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="description" id="description_update" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto Sampul Baru (Optional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="photos[]" multiple accept="image/*" id="photos_update">
                                <label class="custom-file-label">Pilih Gambar</label>
                            </div>
                            <div id="preview-update" class="mt-2 d-flex flex-wrap"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + (split[1] != undefined ? rupiah + ',' + split[1] : rupiah);
        }

        $(document).ready(function() {
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('admin/manage-master/ebook/all') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'title', name: 'title' },
                    { data: 'category_name', name: 'category_name' },
                    { data: 'author', name: 'author' },
                    { data: 'price_display', name: 'price_display' },
                    { data: 'stock', name: 'stock' },
                    { data: 'photos_preview', name: 'photos_preview' },
                    { data: 'file_preview', name: 'file_preview' }, 
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('.rupiah').on('keyup', function() {
                let val = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(formatRupiah(val));
                $(this).closest('.form-group').find('.raw_price').val(val);
            });

            $('#photos_add').on('change', function() {
                let preview = $('#preview-add');
                preview.empty();
                Array.from(this.files).forEach(file => {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        preview.append(`<img src="${e.target.result}" class="img-thumbnail mr-2 mb-2" style="width:80px">`);
                    };
                    reader.readAsDataURL(file);
                });
            });

            $('.table').on('click', '.edit', function() {
                let id = $(this).data('id');
                $.post("{{ url('admin/manage-master/ebook/get') }}", {id: id, _token: "{{ csrf_token() }}"}, function(data) {
                    $('#id_update').val(data.id);
                    $('#title_update').val(data.title);
                    $('#category_id_update').val(data.category_id);
                    $('#author_update').val(data.author);
                    $('#isbn_update').val(data.isbn);
                    $('#price_update').val(data.price);
                    $('#price_mask_update').val(formatRupiah(data.price));
                    $('#stock_update').val(data.stock);
                    $('#total_pages_update').val(data.total_pages);
                    $('#file_format_update').val(data.file_format);
                    $('#description_update').val(data.description);
                    $('#deleted_photos').val('');
                    
                    if(data.file) {
                        $('#current_file_info').text('File saat ini: ' + data.file.split('/').pop());
                    } else {
                        $('#current_file_info').text('Belum ada file diupload.');
                    }

                    let preview = $('#preview-update');
                    preview.empty();
                    data.photos.forEach(p => {
                        preview.append(`
                            <div class="position-relative mr-2 mb-2 photo-item" data-id="${p.id}">
                                <img src="{{ asset('') }}${p.photo}" class="img-thumbnail" style="width:80px">
                                <button type="button" class="btn btn-danger btn-sm position-absolute btn-remove-photo" style="top:-5px;right:-5px;padding:0 5px">×</button>
                            </div>
                        `);
                    });
                    $('#updateModal').modal('show');
                });
            });

            $(document).on('click', '.btn-remove-photo', function() {
                let container = $(this).closest('.photo-item');
                let id = container.data('id');
                let deleted = $('#deleted_photos').val();
                $('#deleted_photos').val(deleted ? deleted + ',' + id : id);
                container.remove();
            });

            $('.table').on('click', '.hapus', function() {
                let id = $(this).data('id');
                swal({
                    title: "Hapus Ebook?",
                    text: "File ebook dan data terkait akan dihapus permanen.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('admin/manage-master/ebook') }}",
                            type: 'DELETE',
                            data: {id: id, _token: "{{ csrf_token() }}"},
                            success: function(res) {
                                swal(res.message, {icon: "success"});
                                $('.table').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection