@component('admin.layouts.content',['title' => 'ویرایش محصولات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ویرایش محصول</li>
    @endslot

    @slot('script')
        <script>

            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('button-image').addEventListener('click', (event) => {
                    event.preventDefault();

                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                });
            });

            // set file link
            function fmSetLink($url) {
                document.getElementById('image_label').value = $url;
            }

            $('#categories').select2({
                'placeholder': 'لطفا دسته بندی های مورد نظر را انتخاب کنید',
                dir: 'rtl'
            });

            $('.attribute-select').select2({tags: true,dir: 'rtl'});

            let changeAttributeValues = (event,id) => {
                let valueBox = $(`select[name='attributes[${id}][value]']`);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                $.ajax({
                    url: '/admin/attribute/values',
                    type: 'POST',
                    data: JSON.stringify({
                        name: event.target.value
                    }),
                    success: function (res){
                        valueBox.html(`
                            <option value="" selected>انتخاب کنید</option>
                            ${
                            res.data.map(function (item){
                                return `<option value="${item}">${item}</option>`;
                            })
                        }
                       `);
                    }
                });
            }

            let createNewAttr = ({attributes,id}) => {

                return `
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                <label>عنوان ویژگی</label>
                                <select name="attributes[${id}][name]" onchange="changeAttributeValues(event,${id});" class="attribute-select form-control">
                                    <option value="">انتخاب کنید</option>
                                    ${
                    attributes.map(function (item){
                        return `<option value="${item}">${item}</option>`;
                    })
                }
                                </select>
                            </div>
                        </div>
                          <div class="col-5">
                                <div class="from-group">
                                    <label>مقدار ویژگی</label>
                                    <select name="attributes[${id}][value]" class="attribute-select form-control">
                                        <option value="">انتخاب کنید</option>
                                    </select>
                                </div>
                          </div>
                    <div class="col-2">
                        <label>اقدامات</label>
                        <div>
                            <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                        </div>
                    </div>
                    </div>

               `;
            }

            $('#add_product_attribute').click(function (){
                let attributesSection = $('#attribute_section');
                let id = attributesSection.children().length

                let attributes = $('#attributes').data('attributes');
                attributesSection.append(
                    createNewAttr({
                        attributes,
                        id
                    })
                );

                $('.attribute-select').select2({tags: true,dir: 'rtl'});
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
                <div id="attributes" data-attributes="{{ json_encode(\App\Models\Attribute::all()->pluck('name')) }}"></div>
                <form class="form-horizontal" action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
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

{{--                            <label for="inputName" class="col-sm-2 control-label">عکس شاخص</label>--}}

{{--                            <div class="col-sm-12">--}}
{{--                                <input type="file" name="file" class="form-control">--}}
{{--                            </div>--}}

                            <div class="input-group">
                                <input type="text" dir="ltr" id="image_label" class="form-control" name="image"
                                       aria-label="Image" aria-describedby="button-image" value="{{ $product->image }}">

                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button" id="button-image">انتخاب</button>
                                </div>
                            </div>

                            <img class="w-25 mt-2" src="{{ $product->image }}" alt="product-image">

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

                        <h6>ویژگی محصول</h6>
                        <hr>
                        <div id="attribute_section">
                            @foreach($product->attributes as $attribute)
                                <div class="row" id="attribute-{{ $loop->index }}">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>عنوان ویژگی</label>
                                            <select name="attributes[{{ $loop->index }}][name]" onchange="changeAttributeValues(event,{{ $loop->index }});" class="attribute-select form-control">
                                                <option value="">انتخاب کنید</option>
                                                @foreach(\App\Models\Attribute::all() as $attr)
                                                    <option value="{{ $attr->name }}" {{ $attr->name == $attribute->name ? 'selected' : '' }}>{{ $attr->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="from-group">
                                            <label>مقدار ویژگی</label>
                                            <select name="attributes[{{ $loop->index }}][value]" class="attribute-select form-control">
                                                <option value="">انتخاب کنید</option>
                                                @foreach($attribute->values as $value)
                                                    <option value="{{ $value->value }}" {{ $value->id == $attribute->pivot->value_id ? 'selected' : '' }}>{{ $value->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label>اقدامات</label>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-{{ $loop->index }}').remove()">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" id="add_product_attribute">ویژگی جدید</button>
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
