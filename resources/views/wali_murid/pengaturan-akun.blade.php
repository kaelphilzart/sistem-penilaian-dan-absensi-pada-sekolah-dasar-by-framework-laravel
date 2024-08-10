@extends('template.template_waliMurid')

@section('content')
<div class="container mt-2">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="container">
          <h4 class="card-header mt-4 text-center"><b>Pengaturan Akun</b></h4>
          <p class="card-title text-center mt-2"><b>{{ $user->nisn }}</b></p>
          <div class="card-body">
            <form action="{{ route('ubah-user') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control mb-2" value="{{ $user->name }}" disabled>
                <input type="text" class="form-control mb-2" id="name" name="name" placeholder="username boleh ganti atau tidak">
                @error('name')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control mb-2" id="email" name="email" value="{{ $user->email }}">
                @error('email')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection