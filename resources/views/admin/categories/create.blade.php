@component('admin.layouts.content',['title' => 'ایجاد کاربر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">ایجاد کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ایجاد کاربر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">نام کاربر</label>

                            <div class="col-sm-12">
                                <input type="text" name="name" class="form-control" id="inputName"
                                       placeholder="نام کاربر را وارد کنید">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">ایمیل</label>

                            <div class="col-sm-12">
                                <input type="email" name="email" class="form-control" id="inputEmail3"
                                       placeholder="ایمیل را وارد کنید">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">پسورد</label>

                            <div class="col-sm-12">
                                <input type="password" name="password" class="form-control" id="inputPassword3"
                                       placeholder="پسورد را وارد کنید">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class=" control-label">تکرار پسورد</label>

                            <div class="col-sm-12">
                                <input type="password" name="password_confirmation" class="form-control"
                                       id="inputPassword3" placeholder="پسورد را وارد کنید">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-check">
                                <input type="checkbox" name="verify" id="verify" class="form-check-input">
                                <label for="verify" class="form-check-label">اکانت فعال باشد</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ثبت</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
