@extends('master')

@section('title', 'Koleksi Buku Saya - Baleide')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Buku Saya</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Buku Saya</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Perpustakaan Digital Anda</h2>
            <p class="section-lead">
                Daftar semua e-book yang telah Anda beli dan siap untuk dibaca kapan saja.
            </p>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Koleksi E-book</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-mybooks">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="5%">#</th>
                                            <th>Cover</th>
                                            <th>Judul Buku</th>
                                            <th>Penulis</th>
                                            <th>Kategori</th>
                                            <th width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        $('#table-mybooks').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('dashboard/my-books') }}",
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    class: 'text-center',
                    orderable: false, 
                    searchable: false 
                },
                { 
                    data: 'cover', 
                    name: 'cover', 
                    orderable: false, 
                    searchable: false,
                    class: 'text-center'
                },
                { data: 'title', name: 'title' },
                { data: 'author', name: 'author' },
                { data: 'category_name', name: 'category_name' },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    class: 'text-center'
                },
            ],
            language: {
                search: "Cari Buku:",
                lengthMenu: "Tampilkan _MENU_ buku",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ buku",
                paginate: {
                    previous: "<i class='fas fa-chevron-left'></i>",
                    next: "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });
</script>
@endpush