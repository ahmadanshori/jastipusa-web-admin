<ul class="menu">
    <li class="sidebar-item {{ (request()->is('/')) || ( request()->is('home*')) ? 'active' : '' }}">
        <a href="/" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="sidebar-item {{ (request()->is('user*')) ? 'active' : '' }}">
        <a href="{{ route('user.index') }}" class='sidebar-link'>
            <i class="bi bi-person-badge-fill"></i>
            <span>Account</span>
        </a>
    </li>


    <li class="sidebar-item {{ (request()->is('purchase*')) ? 'active' : '' }}">
        <a href="{{ route('purchase.index') }}" class='sidebar-link'>
            <i class="bi bi-basket-fill"></i>
            <span>Purchase Order</span>
        </a>
    </li>

    
    
</ul>