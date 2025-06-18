<ul class="account-nav">
            <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Bảng điều khiển</a></li>
            <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Đơn hàng</a></li>
            <li><a href="account-address.html" class="menu-link menu-link_us-s">Địa chỉ</a></li>
            <li><a href="account-details.html" class="menu-link menu-link_us-s">Thông tin tài khoản</a></li>
            <li><a href="{{ route('wishlist.index') }}" class="menu-link menu-link_us-s">Danh sách yêu thích</a></li>

            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <a href="{{ route('logout') }}" class="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="icon"><i class="icon-settings"></i></div>
                        <div class="text">Đăng xuất</div>
                    </a>
                </form>
            </li>
          </ul>