<style>
    .banner {
        background: url({{getFile(config('location.logo.path').'banner.jpg')}});
        background-size: cover;
    }
</style>

@if(!request()->routeIs('home'))
    <!-- PAGE-BANNER -->
    <div class="banner">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col">
                <div class="header-text">
                    <h2>@yield('title')</h2>
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /PAGE-BANNER -->
@endif
