
<!--------------Education Info----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="educationInfo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseEducationInfo"
            aria-expanded="false"
            aria-controls="collapseEducationInfo"
        >
            <i class="fas fa-graduation-cap"></i>
            @lang('Education Info')
        </button>
    </h5>
    <div
        id="collapseEducationInfo"
        class="accordion-collapse collapse @if($errors->has('educationInfo') || session()->get('name') == 'educationInfo') show @endif"
        aria-labelledby="educationInfo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end pe-3">
                    <button
                        class="add-new btn-flower2"
                        data-bs-toggle="modal"
                        data-bs-target="#educationInfoModal"
                    >
                        @lang('Add new')
                    </button>
                </div>

                <div class="col-md-12">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">@lang('Degree')</th>
                                        <th scope="col">@lang('Institution')</th>
                                        <th scope="col">@lang('Start')</th>
                                        <th scope="col">@lang('End')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>
                            <tbody>
                            @forelse($educationInfo as $data)
                                <tr>
                                    <td>{{$data->degree}}</td>
                                    <td>{{$data->institution}}</td>
                                    <td>{{dateTime(@$data->start,'d M, Y')}}</td>
                                    <td>{{dateTime(@$data->end,'d M, Y')}}</td>
                                    <td>
                                        <button class="action-btn success edit-button" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#educationInfoEditModal"
                                                data-degree="{{$data->degree}}"
                                                data-institution="{{$data->institution}}"
                                                data-start="{{$data->start}}"
                                                data-end="{{$data->end}}"
                                                data-route="{{route('user.educationInfoUpdate',['id'=>$data->id])}}"
                                        >
                                                <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="action-btn danger notiflix-confirm"
s-                                              data-bs-toggle="modal"
                                                data-bs-target="#delete-modal"
                                                data-route="{{route('user.educationInfoDelete',['id'=>$data->id])}}"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('No Education Info Found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('modal-here')
    <!--------------Education Info Create Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="educationInfoModal"
        tabindex="-1"
        aria-labelledby="educationInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationInfoLabel">
                        @lang('Add New Education Info')
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="{{route('user.educationInfoCreate')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="degree">@lang('Degree')</label> <span class="text-danger">*</span>
                            <input type="text" name="degree" class="form-control" placeholder="@lang('Your Degree')" value="{{old('degree')}}" required/>
                            @if($errors->has('degree'))
                                <div class="error text-danger">@lang($errors->first('degree')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="institution">@lang('Institution')</label> <span class="text-danger">*</span>
                            <input type="text" name="institution" class="form-control" placeholder="@lang('Your Institution')" required value="{{old('institution')}}"/>
                            @if($errors->has('institution'))
                                <div class="error text-danger">@lang($errors->first('institution')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
                            <input type="date" name="start" class="form-control" value="{{old('start')}}" required/>
                            @if($errors->has('start'))
                                <div class="error text-danger">@lang($errors->first('start')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="end">@lang('End Date')</label> <span class="text-danger">*</span>
                            <input type="date" name="end" class="form-control" value="{{old('end')}}" required/>
                            @if($errors->has('end'))
                                <div class="error text-danger">@lang($errors->first('end')) </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn-flower2 btn1"
                            data-bs-dismiss="modal"
                        >
                            @lang('Cancel')
                        </button>
                        <button type="submit" class="btn-flower2 btn2">
                            @lang('Submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--------------Education Info Edit Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="educationInfoEditModal"
        tabindex="-1"
        aria-labelledby="educationInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="educationInfoLabel">
                        @lang('Edit Education Info')
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="" method="post" id="editForm">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="degree">@lang('Degree')</label> <span class="text-danger">*</span>
                            <input type="text" name="degree" class="form-control degree" placeholder="@lang('Your Degree')" value="{{old('degree')}}" required/>
                            @if($errors->has('degree'))
                                <div class="error text-danger">@lang($errors->first('degree')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="institution">@lang('Institution')</label> <span class="text-danger">*</span>
                            <input type="text" name="institution" class="form-control institution" placeholder="@lang('Your Institution')" required value="{{old('institution')}}"/>
                            @if($errors->has('institution'))
                                <div class="error text-danger">@lang($errors->first('institution')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
                            <input type="date" name="start" class="form-control start" value="{{old('start')}}" required/>
                            @if($errors->has('start'))
                                <div class="error text-danger">@lang($errors->first('start')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="end">@lang('End Date')</label> <span class="text-danger">*</span>
                            <input type="date" name="end" class="form-control end" value="{{old('end')}}" required/>
                            @if($errors->has('end'))
                                <div class="error text-danger">@lang($errors->first('end')) </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn-flower2 btn1"
                            data-bs-dismiss="modal"
                        >
                            @lang('Cancel')
                        </button>
                        <button type="submit" class="btn-flower2 btn2">
                            @lang('Update')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!----------- Education Info Delete Modal ----------------->
    <div id="delete-modal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Confirmation')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn-flower2 btn2">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endpush


@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '.edit-button', function () {
                $('#editForm').attr('action', $(this).data('route'))
                $('.degree').val($(this).data('degree'))
                $('.institution').val($(this).data('institution'))
                $('.start').val($(this).data('start'))
                $('.end').val($(this).data('end'))
            })


            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })

        });
    </script>
@endpush
