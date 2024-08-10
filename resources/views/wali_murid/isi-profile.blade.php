@extends('template.template_waliMurid')

@section('content')
<div class="card mt-4">

<h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
<div class="container">

    <div class="card-body">
    <form action="{{route('input-profile')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN Peserta</label>
                        <input type="number" class="form-control" id="nisn" name="nisn" min="0" placeholder="Masukkan NISN">
                        @error('nisn')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Done</button>
                </form>
    </div>
</div>
           
</div>
@endsection