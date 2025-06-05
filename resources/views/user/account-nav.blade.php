<ul class="account-nav">
            <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
            <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Orders</a></li>
            <li><a href="account-address.html" class="menu-link menu-link_us-s">Addresses</a></li>
            <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
            <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>

            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="{{ route('logout') }}" class="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="icon"><i class="icon-settings"></i></div>
                        <div class="text">Log out</div>
                    </a>
                </form>
            </li>
          </ul>