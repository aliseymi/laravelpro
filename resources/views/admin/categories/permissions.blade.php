@component('admin.layouts.content',['title' => 'دسترسی های کاربر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">لیست کاربران</a></li>
        <li class="breadcrumb-item active">دسترسی های کاربر</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم دسترسی های کاربر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.users.permissions.store',$user->id) }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="permissions" class="col-sm-2 control-label">دسترسی ها</label>

                            <div class="col-sm-12">
                                <select name="permissions[]" id="permissions" class="form-control" multiple>
                                    @foreach(\App\Models\Permission::all() as $permission)
                                        <option value="{{ $permission->id }}" {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }} - {{ $permission->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="roles" class="col-sm-2 control-label">مقام ها</label>

                            <div class="col-sm-12">
                                <select name="roles[]" id="roles" class="form-control" multiple>
                                    @foreach(\App\Models\Role::all() as $role)
                                        <option value="{{ $role->id }}" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->name }} - {{ $role->label }}</option>
                                    @endforeach
                                </select>
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

    @slot('script')
        <script>
            $('#roles').select2({
                'placeholder': 'دسترسی های مورد نظر را انتخاب کنید',
                dir: 'rtl'
            });
            $('#permissions').select2({
                'placeholder': 'مقام های مورد نظر را انتخاب کنید',
                dir: 'rtl'
            });
        </script>
    @endslot
@endcomponent
