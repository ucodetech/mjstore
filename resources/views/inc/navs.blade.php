<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item menu-open">
        <a href="{{ route('superuser.super.dashboard') }}" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('superuser.super.profile') }}" class="nav-link">
          <i class="nav-icon fa fa-user-circle"></i>
          <p>
            Profile
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        
        
      </li>
      <li class="nav-header">User Management</li>
      <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('superuser.super.superuser.page') }}" class="nav-link">
                  <i class="fa fa-user-secret nav-icon"></i>
                  <p>Superusers</p>
                </a>
              </li>
          <li class="nav-item">
            <a href="{{ route('superuser.super.user.page') }}" class="nav-link">
              <i class="fa fa-users nav-icon"></i>
              <p>Users</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superuser.super.seller.page') }}" class="nav-link">
              <i class="fa fa-users nav-icon"></i>
              <p>Sellers</p>
            </a>
          </li>
         
        </ul>
      </li>
      <li class="nav-header">Store Management</li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-store"></i>
          <p>
            Store Management
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('superuser.super.banner.page') }}" class="nav-link">
              <i class="fa fa-image nav-icon"></i>
              <p>Banners</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superuser.super.currency') }}" class="nav-link">
              <i class="fa fa-money-bill-wave nav-icon"></i>
              <p>Currency</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superuser.super.product.category.page') }}" class="nav-link">
              <i class="fa fa-layer-group nav-icon"></i>
              <p>Category(Product)</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superuser.super.brands.page') }}" class="nav-link">
              <i class="fa fa-briefcase nav-icon"></i>
              <p>Brands</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-store"></i>
              <p>
                Product Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('superuser.super.products.page') }}" class="nav-link">
                  <i class="fa fa-briefcase nav-icon"></i>
                  <p>Products</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('superuser.super.add.product.page') }}" class="nav-link">
                  <i class="fa fa-plus nav-icon"></i>
                  <p>Add Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('superuser.super.page.colors') }}" class="nav-link">
                  <i class="fa fa-coins nav-icon"></i>
                  <p>Colors</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('superuser.super.page.sizes') }}" class="nav-link">
                  <i class="fa fa-coins nav-icon"></i>
                  <p>Sizes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('superuser.super.page.conditions') }}" class="nav-link">
                  <i class="fa fa-coins nav-icon"></i>
                  <p>Conditions</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="{{ route('superuser.super.orders') }}" class="nav-link">
              <i class="fa fa-layer-group nav-icon"></i>
              <p>Orders</p>
            </a>
          </li>
                  
          <li class="nav-item">
            <a href="{{ route('superuser.super.shipping.method') }}" class="nav-link">
              <i class="fa fa-layer-group nav-icon"></i>
              <p>Shipping Method</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="pages/examples/contact-us.html" class="nav-link">
              <i class="fa fa-heart nav-icon"></i>
              <p>Wishlist</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superuser.super.coupon.page') }}" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Coupons</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-header">Post Management</li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-item fa fa-blog"></i>
          <p>
            Post Management
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="pages/examples/invoice.html" class="nav-link">
                  <i class="fa fa-blog nav-icon"></i>
                  <p>Posts</p>
                </a>
              </li>
          <li class="nav-item">
            <a href="pages/examples/invoice.html" class="nav-link">
              <i class="fa fa-layer-group nav-icon"></i>
              <p>Post Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/contact-us.html" class="nav-link">
              <i class="fa fa-tag nav-icon"></i>
              <p>Tags</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/contact-us.html" class="nav-link">
              <i class="fa fa-tags nav-icon"></i>
              <p>Post Tags</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/contact-us.html" class="nav-link">
              <i class="fa fa-star nav-icon"></i>
              <p>Reviews</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/examples/contact-us.html" class="nav-link">
              <i class="far fa-comment nav-icon"></i>
              <p>Comments</p>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a href="pages/examples/faq.html" class="nav-link">
          <i class="fas fa-question-circle nav-icon"></i>
          <p>FAQ</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('superuser.super.settings.index') }}" class="nav-link">
          <i class="fa fa-cog nav-icon"></i>
          <p>Settings</p>
        </a>
      </li>
     
    </ul>
  </nav>