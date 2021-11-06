@component('admin.layouts.content',['title' => 'ویرایش محصولات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ویرایش محصول</li>
    @endslot

    @slot('script')
        <script>
            $('#categories').select2({
                'placeholder': 'لطفا دسته بندی های مورد نظر را انتخاب کنید',
                dir: 'rtl'
            });
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.error')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('admin.products.update',$product->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">

                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">نام محصول</label>

                            <div class="col-sm-12">
                                <input type="text" name="title" class="form-control" id="inputName"
                                       placeholder="نام محصول را وارد کنید" value="{{ old('title',$product->title) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">توضیحات</label>

                            <div class="col-sm-12">
                                <textarea class="form-control" placeholder="توضیحات را وارد کنید" name="description" id="description" cols="30" rows="10">{{ old('description',$product->description) }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inventory" class="col-sm-2 control-label">موجودی</label>

                            <div class="col-sm-12">
                                <input type="number" name="inventory" class="form-control" id="inventory"
                                       placeholder="موجودی را وارد کنید" value="{{ old('inventory',$product->inventory) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price" class=" control-label">قیمت</label>

                            <div class="col-sm-12">
                                <input type="number" name="price" class="form-control"
                                       id="price" placeholder="قیمت را وارد کنید" value="{{ old('price',$product->price) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="categories" class="col-sm-2 control-label">دسته بندی ها</label>

                            <div class="col-sm-12">
                                <select name="categories[]" class="form-control" id="categories" multiple>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id,$product->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent
