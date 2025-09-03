<!--------------Career Info----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="careerInfo">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseCareerInfo"
            aria-expanded="false"
            aria-controls="collapseCareerInfo"
        >
            <i class="far fa-user-graduate"></i>
            @lang('Career Info')
        </button>
    </h5>
    <div
        id="collapseCareerInfo"
        class="accordion-collapse collapse @if($errors->has('careerInfo') || session()->get('name') == 'careerInfo') show @endif"
        aria-labelledby="careerInfo"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end pe-3">
                    <button
                        class="add-new btn-flower2"
                        data-bs-toggle="modal"
                        data-bs-target="#careerInfoModal"
                    >
                        @lang('Add new')
                    </button>
                </div>

                <div class="col-md-12">
                    <div class="table-wrapper table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Designation')</th>
                                <th scope="col">@lang('Company')</th>
                                <th scope="col">@lang('Start')</th>
                                <th scope="col">@lang('End')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($careerInfo as $data)
                                <tr>
                                    <td>{{$data->designation}}</td>
                                    <td>{{$data->company}}</td>
                                    <td>{{dateTime(@$data->start,'d M, Y')}}</td>
                                    <td>
                                        @if(isset($data->end))
                                            {{dateTime(@$data->end,'d M, Y')}}
                                        @else
                                            @lang('N/A')
                                        @endif
                                    </td>
                                    <td>
                                        <button class="action-btn success edit-button" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#careerInfoEditModal"
                                                data-designation="{{$data->designation}}"
                                                data-company="{{$data->company}}"
                                                data-start="{{$data->start}}"
                                                data-end="{{$data->end}}"
                                                data-route="{{route('user.careerInfoUpdate',['id'=>$data->id])}}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="action-btn danger notiflix-confirm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#delete-modal"
                                                data-route="{{route('user.careerInfoDelete',['id'=>$data->id])}}"
                                        >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">@lang('No Career Info Found')</td>
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
    <!--------------Career Info Create Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="careerInfoModal"
        tabindex="-1"
        aria-labelledby="careerInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="careerInfoLabel">
                        @lang('Add New Career Info')
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="{{route('user.careerInfoCreate')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="designation">@lang('Designation')</label> <span class="text-danger">*</span>
                            <input type="text" name="designation" class="form-control" placeholder="@lang('Your Designation')"
                                   value="{{old('designation')}}" required/>
                            @if($errors->has('designation'))
                                <div class="error text-danger">@lang($errors->first('designation')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="company">@lang('Company')</label> <span class="text-danger">*</span>
                            <input type="text" name="company" class="form-control"
                                   placeholder="@lang('Company Name')" required value="{{old('company')}}"/>
                            @if($errors->has('company'))
                                <div class="error text-danger">@lang($errors->first('company')) </div>
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
                            <label for="end">@lang('End Date')</label>
                            <input type="date" name="end" class="form-control" value="{{old('end')}}"/>
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


    <!--------------Career Info Edit Modal----------------->
    <div
        class="modal fade modal-with-form"
        id="careerInfoEditModal"
        tabindex="-1"
        aria-labelledby="careerInfoLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="careerInfoLabel">
                        @lang('Edit Career Info')
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <form action="" method="post" class="editForm">
                    @method('put')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="designation">@lang('Designation')</label> <span class="text-danger">*</span>
                            <input type="text" name="designation" class="form-control designation"
                                   placeholder="@lang('Your Designation')" value="{{old('designation')}}" required/>
                            @if($errors->has('designation'))
                                <div class="error text-danger">@lang($errors->first('designation')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="company">@lang('Company')</label> <span class="text-danger">*</span>
                            <input type="text" name="company" class="form-control company"
                                   placeholder="@lang('Company Name')" required value="{{old('company')}}"/>
                            @if($errors->has('company'))
                                <div class="error text-danger">@lang($errors->first('company')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="start">@lang('Start Date')</label> <span class="text-danger">*</span>
                            <input type="date" name="start" class="form-control start" value="{{old('start')}}"
                                   required/>
                            @if($errors->has('start'))
                                <div class="error text-danger">@lang($errors->first('start')) </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="end">@lang('End Date')</label>
                            <input type="date" name="end" class="form-control end" value="{{old('end')}}"/>
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


    <!----------- Career Info Delete Modal ----------------->
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
                $('.editForm').attr('action', $(this).data('route'))
                $('.designation').val($(this).data('designation'))
                $('.company').val($(this).data('company'))
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
