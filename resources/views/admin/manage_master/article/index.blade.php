@extends('master')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Artikel</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Artikel</h4>
                            <div class="card-header-action">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                    <i class="fas fa-plus"></i> Tambah Artikel
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableArticle">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="10%">Thumbnail</th>
                                            <th width="20%">Judul</th>
                                            <th width="15%">Penulis</th>
                                            <th width="15%">Kategori</th>
                                            <th width="15%">Tag</th>
                                            <th width="10%">Tanggal</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Artikel</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formTambah" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Penulis <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="categories[]" class="form-control select2" multiple required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tag</label>
                        <select name="tags[]" class="form-control select2" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Excerpt (Ringkasan)</label>
                        <textarea name="excerpt" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Konten <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control summernote" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        <small class="text-muted">Max: 2MB (jpeg, png, jpg, webp)</small>
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

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Artikel</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formEdit" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Penulis <span class="text-danger">*</span></label>
                        <input type="text" name="author" id="edit_author" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori <span class="text-danger">*</span></label>
                        <select name="categories[]" id="edit_categories" class="form-control select2" multiple required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tag</label>
                        <select name="tags[]" id="edit_tags" class="form-control select2" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Excerpt (Ringkasan)</label>
                        <textarea name="excerpt" id="edit_excerpt" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Konten <span class="text-danger">*</span></label>
                        <textarea name="content" id="edit_content" class="form-control summernote" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah thumbnail</small>
                        <div id="current_thumbnail" class="mt-2"></div>
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
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // DataTable
    let table = $('#tableArticle').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url("admin/manage-master/artikel/all") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'thumbnail_preview', name: 'thumbnail_preview', orderable: false },
            { data: 'title', name: 'title' },
            { data: 'author', name: 'author' },
            { data: 'categories_display', name: 'categories_display', orderable: false },
            { data: 'tags_display', name: 'tags_display', orderable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Form Tambah
    $('#formTambah').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ url("admin/manage-master/artikel") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modalTambah').modal('hide');
                $('#formTambah')[0].reset();
                $('.summernote').summernote('reset');
                table.ajax.reload();
                iziToast.success({
                    title: 'Berhasil',
                    message: response.message,
                    position: 'topRight'
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    iziToast.error({
                        title: 'Error',
                        message: errors[key][0],
                        position: 'topRight'
                    });
                }
            }
        });
    });

    // Edit Button
    $('body').on('click', '.edit', function() {
        let id = $(this).data('id');
        
        $.post('{{ url("admin/manage-master/artikel/get") }}', {
            _token: '{{ csrf_token() }}',
            id: id
        }, function(response) {
            $('#edit_id').val(response.article.id);
            $('#edit_title').val(response.article.title);
            $('#edit_author').val(response.article.author);
            $('#edit_excerpt').val(response.article.excerpt);
            $('#edit_content').summernote('code', response.article.content);
            
            $('#edit_categories').val(response.category_ids).trigger('change');
            $('#edit_tags').val(response.tag_ids).trigger('change');
            
            if (response.article.thumbnail) {
                $('#current_thumbnail').html(`<img src="{{ asset('') }}${response.article.thumbnail}" width="100" class="img-thumbnail">`);
            }
            
            $('#modalEdit').modal('show');
        });
    });

    // Form Edit
    $('#formEdit').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ url("admin/manage-master/artikel/update") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#modalEdit').modal('hide');
                table.ajax.reload();
                iziToast.success({
                    title: 'Berhasil',
                    message: response.message,
                    position: 'topRight'
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                for (let key in errors) {
                    iziToast.error({
                        title: 'Error',
                        message: errors[key][0],
                        position: 'topRight'
                    });
                }
            }
        });
    });

    // Delete Button
    $('body').on('click', '.hapus', function() {
        let id = $(this).data('id');
        
        swal({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus artikel ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '{{ url("admin/manage-master/artikel") }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        table.ajax.reload();
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<style>
.select2-container--bootstrap4 .select2-selection {
    height: auto !important;
}
</style>
@endpush