@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-4">Kelola Merek Kendaraan</h3>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Tambah Merek</h5>
                <form action="{{ route('brands.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Merek</label>
                        <input type="text" name="brand_name" class="form-control" placeholder="Honda / Yamaha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Merek</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nama Merek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $b->brand_name }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection