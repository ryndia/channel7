<nav class="m-0 p-0 navbar-expand-lg">
  <div class="container-fluid m-0">
    <div class="d-flex">
      <div class="ms-start">
        <a href="/register"><i class="navicon bi bi-person-circle"></i></i></a>
      </div>
      <div class="navicon ms-auto social_logo_share">
        <i class="navicon ps-2 bi bi-facebook"></i>
        <i class="navicon ps-2 bi bi-whatsapp"></i>
        <i class="navicon ps-2 bi bi-twitter"></i>
        <i class="navicon ps-2 bi bi-share-fill"></i>
      </div>
  </div>
</nav>
<nav class="navbar m-0 p-0 navbar-expand-lg">
  <div class="container-fluid">
    <div class="logo-badge d-flex mx-md-auto mx-5 mb-0">
      <a href="/"><img class="logo" src="../image/7.png"></a>
    </div>
  </div>
</nav>
<nav class="navbar m-0 p-0 navbar-expand-lg">
  <div class="container-fluid">
    <div class="d-flex mx-md-auto mx-0 py-2 mb-0">
      <p id="date" class="my-0 text-center text-uppercase"></p>
    </div>
  </div>
</nav>
<nav class="navbar navbar2 py-0 navbar-expand-lg">
  <div class="container-fluid">
    <button
      class="navbar-toggler py-0"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarLeftAlignExample"
      aria-controls="navbarLeftAlignExample"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="bi bi-justify py-0" style="color:white;"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarLeftAlignExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link navbarItem active" aria-current="page" href="/">Home</a>
        </li>
        @foreach($navitem as $item)
        <li class="nav-item">
          <a class="nav-link navbarItem active" aria-current="page" href="{{ route('section', ['category' => $item->id]) }}">{{$item->name}}</a>
        </li>
        @endforeach
      </ul>
    </div>
    <div class="">
      <form action="{{ route('search')}}" method="GET" class="d-flex input-group w-auto">
        <div>
          <input
            id = "search_bar"
            type="search"
            class="form-control bg-dark border border-0 rounded-0"
            placeholder="Search"
            aria-label="Search"
            aria-describedby="search-addon"
            name="query"
            />
        </div>
        <div>
          <button type="submit" class="btn btn-primary border border-0 rounded-0" >
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</nav>