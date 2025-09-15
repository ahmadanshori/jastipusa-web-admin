<ul class="menu">
    <li class="sidebar-item {{ (request()->is('/')) || ( request()->is('home*')) ? 'active' : '' }}">
        <a href="/" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard Analytics</span>
        </a>
    </li>

    <li class="sidebar-item {{ (request()->is('tracking*')) ? 'active' : '' }}">
        <a href="{{ route('tracking.index') }}" class='sidebar-link'>
            <i class="bi bi-geo-alt-fill"></i>
            <span>Tracking</span>
        </a>
    </li>

     <li class="sidebar-item {{ (request()->is('purchase*')) ? 'active' : '' }}">
        <a href="{{ route('purchase.index') }}" class='sidebar-link'>
            <i class="bi bi-basket-fill"></i>
            <span>Order</span>
        </a>
    </li>
       @if (App\Models\User::checkRole('master_admin'))
     <li class="sidebar-item {{ (request()->is('customer*')) ? 'active' : '' }}">
        <a href="{{ route('customer.index') }}" class='sidebar-link'>
            <i class="bi bi-person-lines-fill"></i>
            <span>Customer</span>
        </a>
    </li>
    @endif
    @if (App\Models\User::checkRole('master_admin'))
    <li class="sidebar-item {{ (request()->is('user*')) ? 'active' : '' }}">
        <a href="{{ route('user.index') }}" class='sidebar-link'>
            <i class="bi bi-person-badge-fill"></i>
            <span>Account</span>
        </a>
    </li>
    @endif
      @if (App\Models\User::checkRole('master_admin'))
    <li class="sidebar-item {{ (request()->is('payment-method*')) ? 'active' : '' }}">
        <a href="{{ route('payment-method.index') }}" class='sidebar-link'>
            <i class="bi bi-credit-card-fill"></i>
            <span>Payment Method</span>
        </a>
    </li>
    @endif

      @if (App\Models\User::checkRole('master_admin'))
    <li class="sidebar-item {{ (request()->is('exchange*')) ? 'active' : '' }}">
        <a href="{{ route('exchange.index') }}" class='sidebar-link'>
            <i class="bi bi-currency-dollar"></i>
            <span>Exchange</span>
        </a>
    </li>
    @endif

     @if (App\Models\User::checkRole('master_admin'))
    <li class="sidebar-item {{ (request()->is('category*')) ? 'active' : '' }}">
        <a href="{{ route('category.index') }}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Category</span>
        </a>
    </li>
    @endif

     @if (App\Models\User::checkRole('master_admin'))
    <li class="sidebar-item {{ (request()->is('brand*')) ? 'active' : '' }}">
        <a href="{{ route('brand.index') }}" class='sidebar-link'>
            <i class="bi bi-tags-fill"></i>
            <span>Brand</span>
        </a>
    </li>
    @endif






</ul>
