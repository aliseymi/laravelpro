@component('admin.layouts.content',['title' => 'ویرایش دسته بندی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">لیست دسته بندی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسته بندی</li>
    @endslot

    @slot('script')
        <script>
            $('#parent').select2({
                dir: 'rtl'
            });
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسته بندی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.categories.update',$category->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">نام دسته بندی</label>

                            <div class="col-sm-12">
                                <input type="text" name="name" class="form-control" id="inputName"
                                       placeholder="نام دسته بندی را وارد کنید" value="{{ old('name',$category->name) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parent" class="col-sm-2 control-label">دسته بندی والد</label>

                            <div class="col-sm-12">
                                <select name="parent" id="parent" class="form-control">
                                    <option value="0" selected disabled>درصورت نیاز یک دسته بندی را انتخاب کنید</option>
                                    @foreach(\App\Models\Category::all() as $cate)
                                        @if($cate->id === $category->id)
                                            @continue
                                        @endif
                                        <option value="{{ $cate->id }}" {{ $cate->id === $category->parent ? 'selected' : '' }}>{{ $cate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
