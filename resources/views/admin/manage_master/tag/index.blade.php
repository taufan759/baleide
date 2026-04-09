@extends('master')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manajemen Tag Artikel</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Tag Artikel</h4>
                            <div class="card-header-action">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
                                    <i class="fas fa-plus"></i> Tambah Tag
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableTag">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="35%">Nama Tag</th>
                                            <th width="35%">Slug</th>
                                            <th width="15%">Jumlah Artikel</th>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tag Artikel</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formTambah">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Tag <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                        <small class="text-muted">Slug akan dibuat otomatis dari nama</small>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tag Artikel</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formEdit">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Tag <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
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
<script>
$(document).ready(function() {
    loadData();

    function loadData() {
        $.get('{{ url("admin/manage-master/tag/all") }}', function(response) {
            let html = '';
            response.data.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name}</td>
                        <td><code>${item.slug}</code></td>
                        <td><span class="badge badge-info">${item.articles_count} artikel</span></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit" data-id="${item.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger hapus" data-id="${item.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#tableTag tbody').html(html);
        });
    }

    $('#formTambah').on('submit', function(e) {
        e.preventDefault();
        $.post('{{ url("admin/manage-master/tag") }}', $(this).serialize(), function(response) {
            $('#modalTambah').modal('hide');
            $('#formTambah')[0].reset();
            loadData();
            iziToast.success({
                title: 'Berhasil',
                message: response.message,
                position: 'topRight'
            });
        }).fail(function(xhr) {
            let errors = xhr.responseJSON.errors;
            for (let key in errors) {
                iziToast.error({
                    title: 'Error',
                    message: errors[key][0],
                    position: 'topRight'
                });
            }
        });
    });

    $('body').on('click', '.edit', function() {
        let id = $(this).data('id');
        $.post('{{ url("admin/manage-master/tag/get") }}', {
            _token: '{{ csrf_token() }}',
            id: id
        }, function(data) {
            $('#edit_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#modalEdit').modal('show');
        });
    });

    $('#formEdit').on('submit', function(e) {
        e.preventDefault();
        $.post('{{ url("admin/manage-master/tag/update") }}', $(this).serialize(), function(response) {
            $('#modalEdit').modal('hide');
            loadData();
            iziToast.success({
                title: 'Berhasil',
                message: response.message,
                position: 'topRight'
            });
        }).fail(function(xhr) {
            let errors = xhr.responseJSON.errors;
            for (let key in errors) {
                iziToast.error({
                    title: 'Error',
                    message: errors[key][0],
                    position: 'topRight'
                });
            }
        });
    });

    $('body').on('click', '.hapus', function() {
        let id = $(this).data('id');
        swal({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus tag ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: '{{ url("admin/manage-master/tag") }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        loadData();
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight'
                        });
                    },
                    error: function(xhr) {
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON.message,
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