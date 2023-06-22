@php
    $enableStr = $allowEdit ?? false ? 'disabled' : '';
@endphp

<div class="row mt-5">
    @forelse($tshirts as $index => $tshirtImage)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <a href="{{ route('catalog.show', $tshirtImage->slug) }}">
                    @if ($index < 3 && isset($orderBy) && $orderBy === 'popular_products' && $tshirtImage->customer_id === null)
                        <div class="position-absolute top-0 start-0 bg-success text-white px-2 py-1">
                            <i class="fas fa-star mr-1"></i> Popular
                        </div>
                    @endif

                    @if ($index < 3 && isset($orderBy) && $orderBy === 'new_arrivals' && $tshirtImage->customer_id === null)
                        <div class="position-absolute top-0 start-0 bg-primary text-white px-2 py-1">
                            <i class="bi-exclamation-circle-fill mr-1"></i> New
                        </div>
                    @endif

                    @if ($tshirtImage->customer_id !== null)
                        <div class="position-absolute top-0 start-0 bg-success text-white px-2 py-1">
                            <i class="bi bi-archive-fill mr-1"></i> My Product
                        </div>
                    @endif

                    <img class="card-img-top img-fluid mx-auto d-block image-container"
                        src="{{ route('photo', $tshirtImage) }}" alt="T-Shirt Image">
                </a>

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $tshirtImage->name }}
                        @if (isset($prices) && $prices->isNotEmpty())
                            @if (isset($user) && $user !== null && $tshirtImage->customer_id === $user->id)
                                @can('viewMyProducts', \App\Models\TshirtImage::class)
                                    - {{ $prices->first()->unit_price_own }}
                                    €
                        </h5>
                    @endcan
                @else
                    - {{ $prices->first()->unit_price_catalog }} €</h5>
    @endif
    @endif
    </h5>

    <p class="card-text mt-2">{{ $tshirtImage->description }}</p>
    <a href="{{ route('catalog.show', $tshirtImage->slug) }}" class="btn btn-primary mt-auto">View
        product</a>

    @if ($enableStr)
        <div class="mt-3 d-flex">
            @if (isset($user) && $user->user_type === 'C')
                <a href="{{ route('tshirt.edit', ['user' => $user, 'slug' => $tshirtImage->slug]) }}"
                    class="btn btn-success flex-fill mr-1">Edit</a>
                <div class="flex-fill ml-1">
                    <form method="POST"
                        action="{{ route('tshirt.destroy', ['user' => $user, 'slug' => $tshirtImage->slug]) }}"
                        id="deleteForm_{{ $tshirtImage->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger flex-fill w-100">Delete</button>
                    </form>
                </div>
            @endif
            @if (isset($user) && $user->user_type === 'A')
                @can('update', $tshirtImage)
                    <a href="{{ route('catalog.edit', ['user' => $user, 'slug' => $tshirtImage->slug]) }}"
                        class="btn btn-success flex-fill mr-1">Edit</a>
                @endcan
                @can('delete', $tshirtImage)
                    <div class="flex-fill ml-1">
                        <form method="POST" action="{{ route('catalog.destroy', $tshirtImage) }}"
                            id="deleteForm_{{ $tshirtImage->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger flex-fill w-100">Delete</button>
                        </form>
                    </div>
                @endcan
            @endif
        </div>
    @endif

</div>
</div>
</div>
@empty
<div class="col-md-12">
    <p>No tshirt image found.</p>
</div>
@endforelse
</div>
