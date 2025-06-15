@extends('layouts.app')
@section('title', 'Dashboard Editor')
@section('content')
<div class="container-fluid px-4">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="mt-4 text-primary">Dashboard Editor</h1>
    <p class="mb-4">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Anda login sebagai <b>Editor</b>.</p>

    <div class="row">
        <!-- Card: Berita Menunggu Persetujuan -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Berita Menunggu Persetujuan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingNews->count() }} Berita
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Total Berita Disetujui -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Berita Disetujui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{-- Total berita yang telah dipublikasikan (contoh) --}}
                                {{-- Jika ingin dinamis, hitung di controller --}}
                                {{ \App\Models\News::where('status', 'published')->count() }} Berita
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Berita Pending --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Berita Menunggu Persetujuan</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Wartawan</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingNews as $news)
                        <tr>
                            <td>{{ $news->title }}</td>
                            <td>{{ $news->author->name }}</td>
                            <td>{{ $news->category->name }}</td>
                            <td>
    <form action="{{ route('news.approvals.approve', $news->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-success btn-sm"
                onclick="return confirm('Approve berita?')">Approve</button>
    </form>

    <form action="{{ route('news.approvals.reject', $news->id) }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="notes" value="Berita tidak sesuai ketentuan">
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Reject berita?')">Reject</button>
    </form>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada berita menunggu persetujuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
