
<!--------------Basic Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="basicInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseBasicInformation"
            aria-expanded="false"
            aria-controls="collapseBasicInformation"
        >
            <i class="fas fa-info-circle"></i>
            @lang('Basic Information')
        </button>
    </h5>

    <div
        id="collapseBasicInformation"
        class="accordion-collapse collapse @if($errors->has('basicInfo') || session()->get('name') == 'basicInfo') show @endif"
        aria-labelledby="basicInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.updateInformation')}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row g-3 g-md-4">
                    <div class="col-md-6 form-group">
                        <label for="firstname">@lang('First name')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="firstname"
                            value="{{old('firstname') ?? $user->firstname }}"
                            placeholder="@lang('Enter First Name')"
                        />
                        @if($errors->has('firstname'))
                            <div class="error text-danger">@lang($errors->first('firstname')) </div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="lastname">@lang('last name')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="lastname"
                            value="{{old('lastname') ?? $user->lastname }}"
                            placeholder="@lang('Enter Last Name')"
                        />
                        @if($errors->has('lastname'))
                            <div class="error text-danger">@lang($errors->first('lastname')) </div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="username">@lang('Username')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            class="form-control"
                            name="username"
                            value="{{old('username') ?? $user->username }}"
                            placeholder="@lang('Username')"
                        />
                        @if($errors->has('username'))
                            <div class="error text-danger">@lang($errors->first('username')) </div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email">@lang('Email Address')</label> <span class="text-danger">*</span>
                        <input
                            type="email"
                            class="form-control"
                            value="{{ $user->email }}" readonly
                            placeholder="Ryan"
                        />
                        @if($errors->has('email'))
                            <div class="error text-danger">@lang($errors->first('email')) </div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">@lang('Phone Number')</label> <span class="text-danger">*</span>
                        <input
                            type="text"
                            readonly
                            value="{{$user->phone}}"
                            class="form-control"
                            placeholder="@lang('Enter Phone Number')"
                        />
                        @if($errors->has('phone'))
                            <div class="error text-danger">@lang($errors->first('phone'))</div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="gender">@lang('gender')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="gender"
                            aria-label="gender"
                        >
                            <option value="" selected disabled>@lang('Select Gender')</option>
                            <option value="Male" {{$user->gender == 'Male' ? 'selected' : ''}}>@lang('Male')</option>
                            <option value="Female" {{$user->gender == 'Female' ? 'selected' : ''}}>@lang('Female')</option>
                        </select>
                        @error('gender')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="date_of_birth">@lang('Date of birth')</label> <span class="text-danger">*</span>
                        <input type="date" class="form-control" name="date_of_birth"
                               value="{{old('date_of_birth') ?? $user->date_of_birth }}"/>
                        @error('date_of_birth')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="on_behalf">@lang('On Behalf')</label> <span class="text-danger">*</span>
                        <select
                            name="on_behalf"
                            class="form-select"
                            aria-label="on behalf"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($onBehalf as $data)
                                <option value="{{$data->on_behalf_id}}" {{($user->on_behalf == $data->on_behalf_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('on_behalf')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="marital_status">@lang('Marital Status')</label> <span class="text-danger">*</span>
                        <select
                            name="marital_status"
                            class="form-select"
                            aria-label="Maritial status"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($maritalStatus as $data)
                                <option value="{{$data->marital_status_id}}" {{$user->marital_status == $data->marital_status_id ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('marital_status')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="no_of_children">@lang('Number Of Children')</label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            name="no_of_children"
                            value="{{old('no_of_children') ?? $user->no_of_children }}"
                            class="form-control"
                            placeholder="@lang('Enter no of children')"
                        />
                        @error('no_of_children')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="image">@lang('Profile Image')</label> <span class="text-danger">*</span>
                        <div class="image-input ">
                            <label for="image-upload" id="image-label"><i
                                    class="fas fa-upload"></i></label>
                            <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                            <img class="w-100 preview-image" id="image_preview_container" style="max-width: 200px"
                                 src="{{getFile(config('location.user.path').$user->image)}}"
                                 alt="@lang('user image')">
                        </div>
                        @error('image')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>@lang('Preferred language')</label>

                            <select name="language_id" id="language_id" class="form-control">
                                <option value="" disabled>@lang('Select Language')</option>
                                @foreach($languages as $la)
                                    <option value="{{$la->id}}"
                                        {{ old('language_id', $user->language_id) == $la->id ? 'selected' : '' }}>@lang($la->name)</option>
                                @endforeach
                            </select>

                            @if($errors->has('language_id'))
                                <div
                                    class="error text-danger">@lang($errors->first('language_id')) </div>
                            @endif
                        </div>
                    </div>


                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@push('script')
    <script>
        "use strict";
        $(document).on('click', '#image-label', function () {
            $('#image').trigger('click');
        });

        $(document).on('change', '#image', function () {
            var _this = $(this);
            var newimage = new FileReader();
            newimage.readAsDataURL(this.files[0]);
            newimage.onload = function (e) {
                $('#image_preview_container').attr('src', e.target.result);
            }
        });

    </script>
@endpush
