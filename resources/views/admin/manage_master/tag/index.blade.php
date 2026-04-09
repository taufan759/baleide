@extends('layouts.admin')

@section('title', 'Kelola Tag Artikel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Kelola Tag Artikel</h4>
                    <button class="btn btn-primary" id="btnTambah">
                        <i class="fas fa-plus"></i> Tambah Tag
                    </button>
                </div>
                <div class="card-body">
                    <table id="tableTag" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tag</th>
                                <th>Slug</th>
                                <th>Jumlah Artikel</th>
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

<!-- Modal Form -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTag">
                @csrf
                <input type="hidden" name="id" id="tagId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Tag <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" required>
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
    let table = $('#tableTag').DataTable({
        ajax: {
            url: '{{ url("admin/manage-master/tag/all") }}',
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (data, type, row, meta) => meta.row + 1 },
            { data: 'name' },
            { data: 'slug' },
            { data: 'articles_count' },
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
    
    $('#btnTambah').click(function() {
        $('#formTag')[0].reset();
        $('#tagId').val('');
        $('#modalTitle').text('Tambah Tag');
        $('#modalForm').modal('show');
    });
    
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.post('{{ url("admin/manage-master/tag/get") }}', { id }, function(res) {
            $('#tagId').val(res.id);
            $('#name').val(res.name);
            $('#modalTitle').text('Edit Tag');
            $('#modalForm').modal('show');
        });
    });
    
    $('#formTag').submit(function(e) {
        e.preventDefault();
        const url = $('#tagId').val() 
            ? '{{ url("admin/manage-master/tag/update") }}'
            : '{{ url("admin/manage-master/tag") }}';
        
        $.post(url, $(this).serialize(), function(res) {
            alert(res.message);
            $('#modalForm').modal('hide');
            table.ajax.reload();
        });
    });
    
    $(document).on('click', '.btn-delete', function() {
        if (!confirm('Yakin ingin menghapus tag ini?')) return;
        $.ajax({
            url: '{{ url("admin/manage-master/tag") }}',
            type: 'DELETE',
            data: { id: $(this).data('id') },
            success: function(res) {
                alert(res.message);
                table.ajax.reload();
            }
        });
    });
});
</script>
@endpush