<div class="modal fade" id="edit-user{{$dataUser->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-user', ['id' => $dataUser->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kry" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $dataUser->name }}">
                        @error('nama_kry')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $dataUser->email }}">
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

                    <div class="form-group">
                      <label for="exampleSelectGender">Status</label>
                        <select class="form-control" id="level" name="level" value="{{ $dataUser->email }}">
                        @foreach($data1 as $key => $dataLevel)
                            <option value="{{ $dataLevel->id }}">{{ $dataLevel->nama }}</option>
                            @endforeach
                        </select>
                        @error('level')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                      </div>
                    <!-- tambahkan input lainnya sesuai kebutuhan -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
