@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">

                @if ($user->photo_url)
                    <img src="{{ asset('storage/photos/' . $user->photo_url) }}" alt="avatar"
                         class="rounded-circle img-fluid" style="width: 150px; height: 150px">
                @else
                    <i class="fa fa-user icon icon-lg rounded-circle border"></i>
                @endif

                <h5 class="my-3">{{ $user->name }}</h5>

                @if ($user->user_type === 'A')
                    <p class="text-muted mt-4 mb-1">Administrator</p>
                @endif
                @if ($user->user_type === 'E')
                    <p class="text-muted mt-4 mb-1">Employee</p>
                @endif

            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Full Name</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               id="inputNome" {{ $disabledStr }} value="{{ old('nome', $user->name) }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                               id="inputName" {{ $disabledStr }} value="{{ old('email', $user->email) }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                @if (!$disabledStr)
                    <hr>
                    <div class="form-group">
                        <label for="image">{{ __('Image') }}</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"" id="image"
                        name="image" accept="image/*">
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
