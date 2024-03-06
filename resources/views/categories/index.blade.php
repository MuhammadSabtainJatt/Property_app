@extends('layouts.main')

@section('title')
    Categories
@endsection

@section('page-title')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>@yield('title')</h4>

            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
            </div>

        </div>
    </div>
@endsection

@section('content')

    <section class="section">
        <div class="col-md-12 text-end">
            <button class="btn mb-3 btn-primary btn_add">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z">
                    </path>
                </svg>
                Add Category
            </button>
        </div>

        <div class="card add_category mt-3">

            <div class="card-header">

                <div class="divider">
                    <div class="divider-text">
                        <h4>Create Category</h4>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">

                        {!! Form::open(['url' => route('categories.store'), 'data-parsley-validate', 'files' => true]) !!}

                        <div class=" row">

                            <div class="col-md-4 col-sm-12 form-group mandatory">
                                {{ Form::label('category', __('Category'), ['class' => 'form-label text-center']) }}

                                {{ Form::text('category', '', [
                                    'class' => 'form-control',
                                    'placeholder' => 'Category',
                                    'data-parsley-required' => 'true',
                                ]) }}

                            </div>

                            <div class="col-md-4 col-sm-12 form-group mandatory">
                                {{ Form::label('type', __('Facilities'), ['class' => 'form-label text-center']) }}

                                <select data-placeholder="Choose Facilities" name="parameter_type[]"
                                    class="form-select chosen-select" id="select_parameter_type" multiple
                                    data-parsley-minSelect='1'>
                                    @foreach ($parameters as $parameter)
                                        <option value={{ $parameter->id }}>{{ $parameter->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-4 col-sm-12 form-group mandatory">
                                {{ Form::label('image', __('Image'), ['class' => 'form-label text-center']) }}

                                {{ Form::file('image', ['class' => 'form-control', 'data-parsley-required' => 'true', 'accept' => 'image/*']) }}

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4 col-sm-12 form-group mandatory">
                                {{ Form::label('title', __('Meta Title'), ['class' => 'form-label text-center']) }}

                                <input type="text" name="meta_title" class="form-control" id="meta_title"
                                    oninput="getWordCount('meta_title','meta_title_count','19.9px arial')"
                                    placeholder="{{ __('Meta title') }}" required>
                                <h6 id="meta_title_count">0</h6>
                            </div>
                            <div class="col-md-4 col-sm-12 form-group mandatory">
                                {{ Form::label('title', __('Meta Keywords'), ['class' => 'form-label text-center']) }}

                                <input type="text" name="meta_keywords" class="form-control" id="meta_keywords"
                                    placeholder="{{ __('Meta Keywords') }}" required>

                            </div>
                            <div class="col-md-4 col-sm-12 form-group mandatory">
                                {{ Form::label('description', __('Meta Description'), ['class' => 'form-label text-center']) }}

                                <textarea id="meta_description" name="meta_description" class="form-control"
                                    oninput="getWordCount('meta_description','meta_description_count','12.9px arial')"></textarea>
                                <h6 id="meta_description_count">0</h6>

                            </div>
                            <div class="col-sm-12 col-md-12 text-end" style="margin-top:2%;">
                                {{ Form::submit('Save', ['class' => 'btn btn-primary me-1 mb-1']) }}
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

        </div>

    </section>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-borderless" aria-describedby="mydesc" class='table-striped'
                            id="table_list" data-toggle="table" data-url="{{ url('categoriesList') }}"
                            data-click-to-select="true" data-responsive="true" data-side-pagination="server"
                            data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200,All]" data-search="true"
                            data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                            data-fixed-columns="true" data-fixed-number="1" data-fixed-right-number="1"
                            data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                            data-pagination-successively-size="3" data-query-params="queryParams">
                            <thead class="thead-dark">

                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true" data-align="center">
                                        {{ __('ID') }}</th>
                                    <th scope="col" data-field="category" data-sortable="true" data-align="center">
                                        {{ __('Category') }}</th>
                                    <th scope="col" data-field="image" data-sortable="false" data-align="center">
                                        {{ __('Image') }}
                                    </th>

                                    <th scope="col" data-field="type" data-sortable="false" data-align="center">
                                        {{ __('Facilities') }}
                                    </th>
                                    <th scope="col" data-field="meta_title" data-sortable="true" data-align="center">
                                        {{ __('Meta Title') }}</th>
                                    <th scope="col" data-field="meta_description" data-sortable="true"
                                        data-align="center">
                                        {{ __('Meta Desription') }}</th>
                                    <th scope="col" data-field="meta_keywords" data-sortable="true"
                                        data-align="center">
                                        {{ __('Meta Keywords') }}</th>

                                    <th scope="col" data-field="enble_disable" data-sortable="false"
                                        data-align="center">
                                        {{ __('Enable/Disable') }}
                                    </th>

                                    <th scope="col" data-field="operate" data-sortable="false" data-align="center">
                                        {{ __('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- EDIT MODEL MODEL -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myModalLabel1">{{ __('Edit Categories') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ url('categories-update') }}" class="form-horizontal" enctype="multipart/form-data"
                        method="POST" data-parsley-validate>

                        {{ csrf_field() }}

                        <input type="hidden" id="old_image" name="old_image">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <input type="hidden" value="{{ system_setting('svg_clr') }}" id="svg_clr">
                        <div class="row">

                        </div>
                        <div class="row">
                            {{-- <div class="col-md-12">
                                <div class="col-md-12 col-12 form-group text-center">

                                    {{ Form::label('image', __('Image'), ['class' => 'col-sm-12 col-form-label']) }}
                                </div>
                                <div class="col-md-12 col-12 form-group text-center">

                                    <input type="button" class="input-btn1 input-btn1-ghost-dashed bottomleft"
                                        value="+">
                                    <input accept="image/*" name='edit_image' type='file' id="edit_image"
                                        style="display: none" />
                                    <img id="blah" height="100" width="110" style="margin-left: 2%;" />
                                </div>
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger error-msg">{{ $error }}</div>
                                    @endforeach
                                @endif

                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12 form-group mandatory mt-1">
                                    {{-- <div class="form-group mandatory"> --}}
                                    <label for="edit_category" class="form-label">{{ __('Category') }}</label>
                                    <input type="text" id="edit_category" class="form-control" placeholder="Name"
                                        name="edit_category" data-parsley-required="true">
                                    {{-- </div> --}}
                                </div>
                                <div class="col-md-12 col-sm-12 form-group mandatory">
                                    {{ Form::label('title', __('Title'), ['class' => 'form-label text-center']) }}

                                    <input type="text" name="edit_meta_title" class="form-control"
                                        id="edit_meta_title"
                                        oninput="getWordCount('edit_meta_title','edit_meta_title_count','19.9px arial')"
                                        placeholder="{{ __('Meta title') }}" required>
                                    <h6 id="edit_meta_title_count">0</h6>
                                </div>
                                <div class="col-md-12 col-sm-12 form-group mandatory mt-1">
                                    {{ Form::label('description', __('Description'), ['class' => 'form-label text-center']) }}

                                    <textarea id="edit_meta_description" name="edit_meta_description" class="form-control" style="height: 74px;"
                                        oninput="getWordCount('edit_meta_description','edit_meta_description_count','12.9px arial')"></textarea>
                                    <h6 id="edit_meta_description_count">0</h6>

                                </div>
                                <div class="col-md-12 col-sm-12 form-group mandatory">
                                    {{ Form::label('keywords', __('Keywords'), ['class' => 'form-label text-center']) }}

                                    {{ Form::text('edit_keywords', '', [
                                        'class' => 'form-control',
                                        'placeholder' => 'Keywords',
                                        'id' => 'edit_keywords',
                                        'data-parsley-required' => 'true',
                                    ]) }}

                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-12 col-md-12 mandatory">
                                    {{ Form::label('type', __('Facilities'), ['class' => 'col-sm-12 col-form-label ']) }}

                                    <div id="output"></div>

                                    <select data-placeholder="Facilities" name="edit_parameter_type[]"
                                        id="edit_parameter_type" multiple class="form-select form-control mandatory">
                                        @foreach ($parameters as $parameter)
                                            <option value={{ $parameter->id }} id='op'>{{ $parameter->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if (count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger error-msg">{{ $error }}</div>
                                        @endforeach
                                    @endif

                                </div>
                                {{ Form::label('Sequence', __('Sequence'), ['class' => 'col-sm-12 col-form-label ']) }}

                                <div class="col-sm-12 sequence">

                                    <div id="par" class="d-flex">

                                    </div>
                                    <input type="hidden" name="update_seq" id="update_seq">

                                </div>
                                <div class="col-sm-12" style="margin-top: 7%">

                                    {{ Form::label('image', __('Image'), ['class' => 'col-sm-12 col-form-label']) }}
                                    <input type="file" name="edit_image" id="edit_image" class="filepond">
                                </div>
                                <div class="col-sm-12 text-center">
                                    <img id="blah" height="100" width="110" style="margin-left: 2%;" />
                                </div>

                            </div>

                        </div>
                        <div class="row">

                        </div>
                        <div class="row">

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">{{ __('Close') }}</button>

                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- EDIT MODEL -->
@endsection

@section('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js"
        integrity="sha512-MrA7WH8h42LMq8GWxQGmWjrtalBjrfIzCQ+i2EZA26cZ7OBiBd/Uct5S3NP9IBqKx5b+MMNH1PhzTsk6J9nPQQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src=https://bevacqua.github.io/dragula/dist/dragula.js></script>
    <script>
        $(document).ready(function() {
            getWordCount("meta_title", "meta_title_count", "19.9px arial");
            getWordCount("meta_description", "meta_description_count", "12.9px arial");
            $('.add_category').hide();
            $('#select_parameter_type').chosen();
            $('#edit_parameter_type').chosen();


        });
        $('.btn_add').on('click', function() {
            $('.add_category').toggle();

        })

        function chk(checkbox) {

            if (checkbox.checked) {

                active(event.target.name);

            } else {

                disable(event.target.name);
            }
        }
        $('#add').hide();

        $('#add_parameter').click(function() {

            $('#add').slideToggle();



        });

        $('.container1').mouseover(function() {
            this.css("background-color", "yellow");
        });
        $('#add_parameter_value').click(function() {

            param = $('#parameter').val();




        });

        function queryParams(p) {
            return {
                sort: p.sort,
                order: p.order,
                offset: p.offset,
                limit: p.limit,
                search: p.search
            };
        }

        function disable(id) {
            $.ajax({
                url: "{{ route('customer.categoriesstatus') }}",
                type: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    "id": id,
                    "status": 0,
                },
                cache: false,
                success: function(result) {

                    if (result.error == false) {
                        Toastify({
                            text: 'Category Deactive successfully',
                            duration: 6000,
                            close: !0,
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                        }).showToast();
                        $('#table_list').bootstrapTable('refresh');
                    } else {
                        Toastify({
                            text: "Something Went Wrong",
                            duration: 6000,
                            close: !0,
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                        }).showToast();
                        $('#table_list').bootstrapTable('refresh');
                    }

                },
                error: function(error) {

                }
            });
        }

        function active(id) {
            $.ajax({
                url: "{{ route('customer.categoriesstatus') }}",
                type: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    "id": id,
                    "status": 1,
                },
                cache: false,
                success: function(result) {

                    if (result.error == false) {
                        Toastify({
                            text: 'Category Active successfully',
                            duration: 6000,
                            close: !0,
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                        }).showToast();
                        $('#table_list').bootstrapTable('refresh');
                    } else {
                        Toastify({
                            text: "Something Went Wrong",
                            duration: 6000,
                            close: !0,
                            backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)"
                        }).showToast();
                        $('#table_list').bootstrapTable('refresh');
                    }
                },
                error: function(error) {

                }
            });
        }

        $('#btn_seq').click(function(e) {
            e.preventDefault();



            var sequence = [];
            $('.seq').each(function() {

                sequence.push($(this).attr('id'));

            });

            $('#update_seq').val(sequence.toString());

        });

        $('#edit_parameter_type').on('change', function(e) {
                e.preventDefault();

                $('#edit_parameter_type option:not(:selected)').each(function() {


                    $('#div_' + this.value).remove();


                    var sequence = [];
                    $('.seq').each(function() {


                        sequence.push($(this).attr('id'));

                    });
                    $('#update_seq').val(sequence.toString());
                });

                ids = $('#par > div').map((i, div) => div.id).get();
                console.log(ids);

                $('#par').html('');

                $("#edit_parameter_type option:selected").each(function() {


                    val_of_opt = this.value;
                    text_of_opt = this.text;


                    if (text_of_opt) {
                        $('#par').append($(
                            '<div class="seq" id=' + val_of_opt +
                            '><span class="badge rounded-pill" style="background:var( --bs-primary);margin-left:2px;">' +
                            text_of_opt + '</span></div>'


                        ));
                    }

                });

                var sequence = [];
                $('.seq').each(function() {


                    sequence.push($(this).attr('id'));


                });
                $('#update_seq').val(sequence.toString());

            }

        );

        function setValue(id) {

            getWordCount("edit_meta_title", "edit_meta_title_count", "19.9px arial");
            getWordCount(
                "edit_meta_description",
                "edit_meta_description_count",
                "12.9px arial"
            );
            var sequence = [];
            $('.seq').empty();
            $('#update_seq').val('');
            $('#par').empty();
            $('#edit_parameter_type_chosen').css('width', '470px');
            $("#edit_id").val(id);
            $("#edit_category").val($("#" + id).parents('tr:first').find('td:nth-child(2)').text());
            $("#edit_meta_title").val($("#" + id).parents('tr:first').find('td:nth-child(5)').text());
            $("#edit_meta_description").val($("#" + id).parents('tr:first').find('td:nth-child(6)').text());
            $("#edit_keywords").val($("#" + id).parents('tr:first').find('td:nth-child(7)').text());

            $("#sequence").val($("#" + id).parents('tr:first').find('td:nth-child(4)').text());

            $("#old_image").val($("#" + id).data('oldimage'));
            $("#status").val($("#" + id).data('status')).trigger('change');
            if ($('#svg_clr').val() == 1) {
                src = ($("#" + id).parents('tr:first').find('td:nth-child(3)').find($('.svg-img'))).attr('src');
            } else {

                src = ($("#" + id).parents('tr:first').find('td:nth-child(3)').find($('.image-popup-no-margins'))).attr(
                    'href');
            }

            $('#blah').attr('src', src);
            $('#edit_image').attr('src', src);
            var type = ($("#" + id).data('types')).toString();

            var type_arr = type.split(',');

            console.log('type::' + type);
            if (type != '') {
                $('#edit_parameter_type').val(type.split(',')).trigger('change');
            } else {
                $('#edit_parameter_type').val('');
            }

            $('#par').empty();
            str = '';

            val_arr = $("#edit_parameter_type").val();

            arr1 = [];
            mapped_arr1 = [];

            $("#edit_parameter_type :selected").each(function(key, value) {


                var arr = type_arr;

                var mapped_arr = type_arr.map(function(val) {
                    return $.inArray(val, [val_arr]) ? val : "no";
                });


                mapped_arr1.push(mapped_arr);
                arr1.push(value.text);


                str += this.value + ',';


            });
            console.log(mapped_arr1[0]);

            $.each(mapped_arr1[0], function(k, v) {

                text_op = ($('#edit_parameter_type option[value="' + v + '"]').text());
                if (v != '') {
                    $('#par').append($(
                        '<div class="seq" id=' + v +
                        '><span class="badge rounded-pill" style="background:var( --bs-primary);margin-left:2px;">' +
                        text_op + '</span></div>'




                    ));
                }

            });

            $("#edit_parameter_type").val(str.split(',')).trigger('chosen:updated');

            var sequence = [];
            $('.seq').each(function() {


                sequence.push($(this).attr('id'));

            });

            $('#update_seq').val(sequence.toString());

            // var containers = document.getElementById('par');

            var containers = [document.getElementById('par')];

            dragula(containers, {
                // Additional options for Dragula can be added here
            }).on('drop', function() {
                var sequence = [];
                var existingIDs = {};

                $('.seq').each(function() {
                    var id = $(this).attr('id');

                    if (!existingIDs[id]) {
                        existingIDs[id] = true;
                        sequence.push(id);
                    }
                });

                console.log(sequence.toString());
                $('#update_seq').val(sequence.join(','));
            });


        }
        var sequence = [];
        $('.seq').each(function() {

            sequence.push($(this).attr('id'));
        });

        $('#update_seq').val(sequence.toString());
        document.getElementById('output').innerHTML = location.search;
        $(".chosen-select").chosen();

        $('.bottomleft').click(function() {
            $('#edit_image').click();


        });
        edit_image.onchange = evt => {
            console.log("click");
            const [file] = edit_image.files
            if (file) {
                blah.src = URL.createObjectURL(file)

            }


        }
    </script>
@endsection
