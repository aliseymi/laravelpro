@component('admin.layouts.content',['title' => 'ویرایش مقام'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">لیست مقام ها</a></li>
        <li class="breadcrumb-item active">ویرایش مقام</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش مقام</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.roles.update',$role->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">نام مقام</label>

                            <div class="col-sm-12">
                                <input type="text" name="name" class="form-control" id="inputName"
                                       placeholder="نام مقام را وارد کنید" value="{{ old('name',$role->name) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">توضیحات</label>

                            <div class="col-sm-12">
                                <input type="text" name="label" class="form-control" id="inputEmail3"
                                       placeholder="توضیحات را وارد کنید" value="{{ old('label',$role->label) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="selectPermission" class="col-sm-2 control-label">دسترسی ها</label>

                            <div class="col-sm-12">
                                <select name="permissions[]" class="form-control" id="selectPermission" multiple>
                                    @foreach(\App\Models\Permission::all() as $permission)
                                        <option value="{{ $permission->id }}" {{ in_array($permission->id,$role->permissions->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $permission->name }} - {{ $permission->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش</button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
