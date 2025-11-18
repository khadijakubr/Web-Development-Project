<div class="card h-100">
  <div class="card-body d-flex flex-column">
    <h5 class="card-title">{{ $name }}</h5>
    <p class="card-text">{{ $description }}</p>
    <div class="mt-auto">
      <p class="fw-bold">Price: ${{ $price }}</p>
      <a href="{{ route('products.show', ['id' => $id ?? '#']) }}" class="btn btn-sm btn-outline-primary">View</a>
      <a href="{{ route('products.edit', ['id' => $id ?? '#']) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
    </div>
  </div>
</div>
