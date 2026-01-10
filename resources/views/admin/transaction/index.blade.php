@extends('master')
@section('title', 'Data Transaksi')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Data Transaksi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Filter Transaksi</h4>
                        <div class="card-header-form">
                            <button type="button" class="btn btn-success btn-sm" onclick="printData()">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="filter-form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status Pembayaran</label>
                                        <select class="form-control" id="payment_status">
                                            <option value="">Semua Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="paid">Paid</option>
                                            <option value="failed">Failed</option>
                                            <option value="expired">Expired</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Dari Tanggal</label>
                                        <input type="date" class="form-control" id="start_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Sampai Tanggal</label>
                                        <input type="date" class="form-control" id="end_date">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="d-block">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="transaction-table">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>Order ID</th>
                                        <th>Pelanggan</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th width="10px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#transaction-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('admin/transactions/all') }}",
                    data: function(d) {
                        d.payment_status = $('#payment_status').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'midtrans_order_id', name: 'midtrans_order_id', defaultContent: '-' },
                    { data: 'user_name', name: 'users.name' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'payment_status', name: 'payment_status' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });

            window.printData = function() {
                var payment_status = $('#payment_status').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var url = "{{ url('admin/transactions/print') }}?payment_status=" + payment_status +
                          "&start_date=" + start_date +
                          "&end_date=" + end_date;
                window.open(url, '_blank');
            };
        });
    </script>
@endsection