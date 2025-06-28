@extends('layouts.dashboard')

@section('title')
    Detail Jenis Pelayanan - Puskesmas Nanggalo Siteba
@endsection

@section('sub_title')
    Detail Jenis Pelayanan: {{ $service->name }}
@endsection

@section('content')
<div class="card card-dashboard mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <i class="fas fa-eye me-1"></i> Informasi Jenis Pelayanan
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nama Pelayanan</dt>
            <dd class="col-sm-9">{{ $service->name }}</dd>

            <dt class="col-sm-3">Deskripsi</dt>
            <dd class="col-sm-9">{{ $service->description }}</dd>

            <dt class="col-sm-3">Dibuat Pada</dt>
            <dd class="col-sm-9">{{ $service->created_at->format('d M Y') }}</dd>

            <dt class="col-sm-3">Terakhir Diperbarui</dt>
            <dd class="col-sm-9">{{ $service->updated_at->format('d M Y') }}</dd>
        </dl>

        <a href="{{ route('services.index') }}" class="btn btn-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Pelayanan
        </a>
    </div>
</div>
@endsection
