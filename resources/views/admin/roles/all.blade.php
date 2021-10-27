@component('admin.layouts.content',['title' => 'لیست مقام ها'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active">لیست مقام ها</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">مقام ها</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="جستجو" value="{{ request('search') }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                        <div class="btn-group-sm mr-1">
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-info">ایجاد مقام جدید<i class="fa fa-plus pr-1"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">

                        <tbody>
                        <tr>
                            <th>نام مقام</th>
                            <th>توضیحات</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label }}</td>
                                <td class="d-flex justify-content-center">
                                    <form action="{{ route('admin.roles.destroy',['role' => $role->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    <button class="btn btn-sm btn-danger ml-1" type="submit">حذف</button>
                                    </form>
                                    <a href="{{ route('admin.roles.edit',['role' => $role->id]) }}" class="btn btn-sm btn-primary">ویرایش</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $roles->render() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent
