@extends('master')
@section('title', 'Data Voucher')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Voucher</h1>
        </div>

        <div class="section-body">
            @if(session('message'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        {{ session('message') }}
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Kelola Voucher Diskon</h4>
                    <div class="card-header-form">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                            <i class="fas fa-plus"></i> Tambah Voucher
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="voucherTable">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th>Diskon (%)</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('admin/manage-master/voucher') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">Tambah Voucher</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Voucher</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kode Voucher</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Persentase Diskon (%)</label>
                        <input type="number" name="discount_percent" class="form-control" required min="1" max="100">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('admin/manage-master/voucher/update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">Edit Voucher</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Voucher</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kode Voucher</label>
                        <input type="text" name="code" id="edit_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Persentase Diskon (%)</label>
                        <input type="number" name="discount_percent" id="edit_discount_percent" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="edit_status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#voucherTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/manage-master/voucher/all') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'discount_percent', name: 'discount_percent'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#voucherTable').on('click', '.edit', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('admin/manage-master/voucher/get') }}",
                type: "POST",
                data: { id: id, _token: "{{ csrf_token() }}" },
                beforeSend: function() { $.LoadingOverlay("show"); },
                success: function(data) {
                    $.LoadingOverlay("hide");
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_code').val(data.code);
                    $('#edit_discount_percent').val(data.discount_percent); 
                    $('#edit_status').val(data.status); 
                    $('#updateModal').modal('show');
                }
            });
        });

        $('#voucherTable').on('click', '.hapus', function() {
            var id = $(this).data('id');
            swal({
                title: "Yakin hapus?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ url('admin/manage-master/voucher') }}",
                        type: "DELETE",
                        data: { id: id, _token: "{{ csrf_token() }}" },
                        success: function(data) {
                            table.ajax.reload();
                            swal("Berhasil!", data.message, "success");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection