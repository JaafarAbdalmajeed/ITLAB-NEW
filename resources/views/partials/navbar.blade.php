  <header class="navbar">
    <div class="navbar-logo">
      <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
        <span>IT</span> LAB
      </a>
    </div>

    <nav class="navbar-links">
      @php
        try {
          $navbarItems = \App\Models\NavbarItem::active()->ordered()->get();
        } catch (\Exception $e) {
          // Fallback to default items if table doesn't exist yet
          $navbarItems = collect([
            (object)['label' => 'Home', 'route' => 'home', 'url' => route('home'), 'icon' => null, 'css_class' => null, 'target' => '_self'],
            (object)['label' => 'Dashboard', 'route' => 'pages.dashboard', 'url' => route('pages.dashboard'), 'icon' => null, 'css_class' => null, 'target' => '_self'],
            (object)['label' => 'HTML', 'route' => 'pages.html', 'url' => route('pages.html'), 'icon' => null, 'css_class' => null, 'target' => '_self'],
            (object)['label' => 'CSS', 'route' => 'pages.css', 'url' => route('pages.css'), 'icon' => null, 'css_class' => null, 'target' => '_self'],
            (object)['label' => 'JavaScript', 'route' => 'pages.js', 'url' => route('pages.js'), 'icon' => null, 'css_class' => null, 'target' => '_self'],
          ]);
        }
      @endphp

      @foreach($navbarItems as $item)
        @php
          // Get URL - use actual_url accessor if it's a NavbarItem model, otherwise use fallback
          if (method_exists($item, 'getActualUrlAttribute') || property_exists($item, 'actual_url')) {
            $url = $item->actual_url;
          } elseif (isset($item->route) && $item->route) {
            try {
              $url = route($item->route);
            } catch (\Exception $e) {
              $url = $item->url ?? '#';
            }
          } else {
            $url = $item->url ?? '#';
          }
          
          // Determine if link is active
          $isActive = false;
          if (isset($item->route) && $item->route) {
            try {
              $isActive = request()->routeIs($item->route . '*');
            } catch (\Exception $e) {
              // Route doesn't exist, check URL
              $path = parse_url($url, PHP_URL_PATH);
              $isActive = request()->is($path) || request()->is($path . '*');
            }
          } else {
            $path = parse_url($url, PHP_URL_PATH);
            $isActive = request()->is($path) || request()->is($path . '*');
          }
        @endphp
        <a href="{{ $url }}" 
           target="{{ $item->target ?? '_self' }}"
           class="{{ trim(($item->css_class ?? '') . ' ' . ($isActive ? 'active' : '')) }}">
          @if(isset($item->icon) && $item->icon)
            <i class="{{ $item->icon }}"></i>
          @endif
          {{ $item->label }}
        </a>
      @endforeach
    </nav>

    <div class="navbar-right">
      <button id="signInBtn" class="nav-btn" type="button">Sign In</button>
    </div>
  </header>
