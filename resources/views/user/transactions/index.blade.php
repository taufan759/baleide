@extends('master')

@section('title', 'Riwayat Pesanan - Baleide')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Pesanan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Riwayat Pesanan</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Daftar Transaksi</h2>
                <p class="section-lead">Pantau status pembayaran dan riwayat pembelian e-book Anda di sini.</p>

                <div class="card">
                    <div class="card-header">
                        <h4>Filter Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <form id="filter-form">
                            <div class="row align-items-end">
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <label for="payment_status" class="form-label">Status Pembayaran</label>
                                    <select class="form-control" id="payment_status" name="payment_status">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Menunggu Pembayaran</option>
                                        <option value="paid">Berhasil (Paid)</option>
                                        <option value="failed">Gagal / Kadaluarsa</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                                <div class="col-md-2 col-sm-12 mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                    <button type="button" class="btn btn-secondary btn-block mt-2" onclick="resetFilter()">Reset</button>
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
                                        <th>ID Transaksi</th>
                                        <th>Daftar Buku</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th width="10px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#transaction-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('dashboard/transactions') }}",
                    type: "GET",
                    data: function(d) {
                        d.payment_status = $('#payment_status').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, class: 'text-center' },
                    { data: 'midtrans_order_id', name: 'midtrans_order_id' },
                    { data: 'books', name: 'books' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: 'payment_status', name: 'payment_status', class: 'text-center' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center' }
                ],
                language: {
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.draw();
            });

            window.resetFilter = function() {
                $('#filter-form')[0].reset();
                table.draw();
            };
        });
    </script>
@endpush