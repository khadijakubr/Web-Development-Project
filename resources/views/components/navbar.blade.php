<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand">E-Book Store</a>
    <form class="d-flex ms-auto" action="{{ route('products.index') }}" method="get">
      <input class="form-control me-2" name="q" value="{{ request('q') }}" placeholder="Search..." />
      <button class="btn btn-outline-primary" type="submit">🔍︎</button>
    </form>
  </div>
</nav>
