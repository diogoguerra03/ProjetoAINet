@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">

                @if ($user->photo_url)
                    <img src="{{ asset('storage/photos/' . $user->photo_url) }}" alt="avatar"
                        class="rounded-circle img-fluid" style="width: 150px;">
                @else
                    <i class="fa fa-user icon icon-lg rounded-circle border"></i>
                @endif

                <h5 class="my-3">{{ $user->name }}</h5>

                @if ($user->user_type === 'C')
                    <p class="text-muted mt-4 mb-1">Client</p>
                @endif
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
                @if ($user->user_type === 'C')
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">NIF</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif"
                                id="inputName" {{ $disabledStr }} value="{{ old('nif', $customer->nif) }}">
                            @error('nif')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" id="inputName" {{ $disabledStr }}
                                value="{{ old('address', $customer->address) }}">
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Payment type</p>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control @error('default_payment_type') is-invalid @enderror"
                                name="default_payment_type" id="inputName" {{ $disabledStr }}>
                                <option value=""
                                    {{ old('default_payment_type', $customer->default_payment_type) === null ? 'selected' : '' }}>
                                    None
                                </option>
                                <option value="PAYPAL"
                                    {{ old('default_payment_type', $customer->default_payment_type) === 'PAYPAL' ? 'selected' : '' }}>
                                    PAYPAL</option>
                                <option value="MC"
                                    {{ old('default_payment_type', $customer->default_payment_type) === 'MC' ? 'selected' : '' }}>
                                    MASTER CARD</option>
                                <option value="VISA"
                                    {{ old('default_payment_type', $customer->default_payment_type) === 'VISA' ? 'selected' : '' }}>
                                    VISA</option>
                            </select>
                            @error('default_payment_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Payment reference</p>
                        </div>
                        <div class="col-sm-9">
                            <input type="text"
                                class="form-control @error('default_payment_ref') is-invalid @enderror"
                                name="default_payment_ref" id="inputName" {{ $disabledStr }}
                                value="{{ old('default_payment_ref', $customer->default_payment_ref) }}">
                            @error('default_payment_ref')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                @endif
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
