@extends('layouts.admin')

@section('title', 'Kelola Artikel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Kelola Artikel</h4>
                    <button class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus"></i> Tambah Artikel
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableArticle" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Thumbnail</th>
                                    <th>Judul</th>
                                    <th>Author</th>
                                    <th>Kategori</th>
                                    <th>Tags</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
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

<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formArticle" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="articleId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Konten Artikel <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="content" id="content" rows="10" required></textarea>
                                <small class="text-muted">Bisa menggunakan HTML</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Excerpt / Ringkasan</label>
                                <textarea class="form-control" name="excerpt" id="excerpt" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Author <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="author" id="author" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" name="categories[]" id="categories" multiple required>
                                    <!-- Akan diisi via AJAX -->
                                </select>
                                <small class="text-muted">Tekan Ctrl untuk pilih banyak</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tags</label>
                                <select class="form-select" name="tags[]" id="tags" multiple>
                                    <!-- Akan diisi via AJAX -->
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
                                <div id="previewThumbnail" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let table;
    
    // Initialize DataTable
    function loadTable() {
        table = $('#tableArticle').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: '{{ url("admin/manage-master/artikel/all") }}',
                dataSrc: 'data'
            },
            columns: [
                { 
                    data: null,
                    render: (data, type, row, meta) => meta.row + 1
                },
                {
                    data: 'thumbnail',
                    render: (data) => data 
                        ? `<img src="/storage/${data}" width="60" class="rounded">`
                        : '<span class="text-muted">No image</span>'
                },
                { data: 'title' },
                { data: 'author' },
                {
                    data: 'categories',
                    render: (data) => data.map(cat => 
                        `<span class="badge bg-info">${cat.name}</span>`
                    ).join(' ')
                },
                {
                    data: 'tags',
                    render: (data) => data.map(tag => 
                        `<span class="badge bg-secondary">${tag.name}</span>`
                    ).join(' ')
                },
                {
                    data: 'created_at',
                    render: (data) => new Date(data).toLocaleDateString('id-ID')
                },
                {
                    data: null,
                    render: (data) => `
                        <button class="btn btn-sm btn-warning btn-edit" data-id="${data.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    `
                }
            ]
        });
    }
    
    // Load categories and tags for select
    function loadSelections() {
        $.get('{{ url("admin/manage-master/artikel-kategori/all") }}', function(res) {
            const options = res.data.map(cat => 
                `<option value="${cat.id}">${cat.name}</option>`
            ).join('');
            $('#categories').html(options);
        });
        
        $.get('{{ url("admin/manage-master/tag/all") }}', function(res) {
            const options = res.data.map(tag => 
                `<option value="${tag.id}">${tag.name}</option>`
            ).join('');
            $('#tags').html(options);
        });
    }
    
    // Show modal for create
    $('#btnTambah').click(function() {
        $('#formArticle')[0].reset();
        $('#articleId').val('');
        $('#modalTitle').text('Tambah Artikel');
        $('#previewThumbnail').html('');
        loadSelections();
        $('#modalForm').modal('show');
    });
    
    // Show modal for edit
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        loadSelections();
        
        $.post('{{ url("admin/manage-master/artikel/get") }}', { id }, function(res) {
            $('#articleId').val(res.article.id);
            $('#title').val(res.article.title);
            $('#content').val(res.article.content);
            $('#excerpt').val(res.article.excerpt);
            $('#author').val(res.article.author);
            
            // Set selected categories and tags
            setTimeout(() => {
                $('#categories').val(res.category_ids);
                $('#tags').val(res.tag_ids);
            }, 200);
            
            if (res.article.thumbnail) {
                $('#previewThumbnail').html(
                    `<img src="/storage/${res.article.thumbnail}" class="img-thumbnail" width="150">`
                );
            }
            
            $('#modalTitle').text('Edit Artikel');
            $('#modalForm').modal('show');
        });
    });
    
    // Submit form
    $('#formArticle').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const url = $('#articleId').val() 
            ? '{{ url("admin/manage-master/artikel/update") }}'
            : '{{ url("admin/manage-master/artikel") }}';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                alert(res.message);
                $('#modalForm').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
    
    // Delete article
    $(document).on('click', '.btn-delete', function() {
        if (!confirm('Yakin ingin menghapus artikel ini?')) return;
        
        const id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/manage-master/artikel") }}',
            type: 'DELETE',
            data: { id },
            success: function(res) {
                alert(res.message);
                table.ajax.reload();
            }
        });
    });
    
    loadTable();
});
</script>
@endpush