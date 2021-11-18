<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/img/IMG_20201019_234014_262.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">سید علی میرعربشاهی</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/admin" class="nav-link {{ isActive('admin.') }}"><i class="nav-icon fa fa-dashboard"></i>پنل مدیریت</a>
                    </li>

                    @can('show-users')
                        <li class="nav-item has-treeview {{ isActive(['admin.users.index','admin.users.create','admin.users.edit','admin.users.permissions'],'menu-open') }}">
                            <a href="#" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit','admin.users.permissions']) }}">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    کاربران
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive(['admin.users.index','admin.users.create','admin.users.edit','admin.users.permissions']) }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست کاربران</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @canany(['show-permissions','show-roles'])
                    <li class="nav-item has-treeview {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit','admin.roles.index','admin.roles.create','admin.roles.edit'],'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit','admin.roles.index','admin.roles.create','admin.roles.edit']) }}">
                            <i class="nav-icon fa fa-id-card"></i>
                            <p>
                                بخش اجازه دسترسی
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                          @can('show-permissions')
                                <li class="nav-item">
                                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive(['admin.permissions.index','admin.permissions.create','admin.permissions.edit']) }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>دسترسی ها</p>
                                    </a>
                                </li>
                          @endcan
                          @can('show-roles')
                                  <li class="nav-item">
                                      <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActive(['admin.roles.index','admin.roles.create','admin.roles.edit']) }}">
                                          <i class="fa fa-circle-o nav-icon"></i>
                                          <p>مقام ها</p>
                                      </a>
                                  </li>
                          @endcan
                        </ul>
                    </li>
                    @endcanany

                    @can('show-products')
                        <li class="nav-item has-treeview {{ isActive(['admin.products.index','admin.products.create','admin.products.edit'],'menu-open') }}">
                            <a href="#" class="nav-link {{ isActive(['admin.products.index','admin.products.create','admin.products.edit']) }}">
                                <i class="nav-icon fa fa-amazon"></i>
                                <p>
                                    بخش محصولات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ isActive(['admin.products.index','admin.products.create','admin.products.edit']) }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>لیست محصولات</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('show-comments')
                        <li class="nav-item has-treeview {{ isActive(['admin.comments.index','admin.comments.unapproved'],'menu-open') }}">
                            <a href="#" class="nav-link {{ isActive(['admin.comments.index','admin.comments.unapproved']) }}">
                                <i class="nav-icon fa fa-comment"></i>
                                <p>
                                    بخش نظرات
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.comments.index') }}" class="nav-link {{ isActive(['admin.comments.index']) }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>نظرات تایید شده</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.comments.unapproved') }}" class="nav-link {{ isActive(['admin.comments.unapproved']) }}">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>نظرات تایید نشده</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    @can('show-categories')
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ isActive(['admin.categories.index','admin.categories.create','admin.categories.edit']) }}"><i class="nav-icon fa fa-table"></i>مدیریت دسته بندی ها</a>
                        </li>
                    @endcan

                    <li class="nav-item has-treeview {{ isActive(['admin.orders.index','admin.orders.payments'] , 'menu-open') }}">
                        <a href="#" class="nav-link {{ isActive(['admin.orders.index','admin.orders.payments']) }}">
                            <i class="nav-icon fa fa-shopping-bag"></i>
                            <p>
                                بخش سفارشات
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'unpaid']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'unpaid'])) }} ">
                                    <i class="fa fa-circle-o nav-icon text-warning"></i>
                                    <p>پرداخت نشده
                                        <span class="badge badge-warning right">{{ \App\Models\Order::whereStatus('unpaid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'paid']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'paid'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-info"></i>
                                    <p>پرداخت شده
                                        <span class="badge badge-info right">{{ \App\Models\Order::whereStatus('paid')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index'  , ['type' => 'preparation']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'preparation'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-primary"></i>
                                    <p>در حال پردازش
                                        <span class="badge badge-primary right">{{ \App\Models\Order::whereStatus('preparation')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'posted']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'posted'])) }}">
                                    <i class="fa fa-circle-o nav-icon text text-light"></i>
                                    <p>ارسال شده
                                        <span class="badge badge-light right">{{ \App\Models\Order::whereStatus('posted')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'received']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'received'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-success"></i>
                                    <p>دریافت شده
                                        <span class="badge badge-success right">{{ \App\Models\Order::whereStatus('received')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.orders.index' , ['type' => 'canceled']) }}" class="nav-link {{ isUrl(route('admin.orders.index' , ['type' => 'canceled'])) }}">
                                    <i class="fa fa-circle-o nav-icon text-danger"></i>
                                    <p>کنسل شده
                                        <span class="badge badge-danger right">{{ \App\Models\Order::whereStatus('canceled')->count() }}</span>
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
