@extends($theme.'layouts.user')
@section('title',__('Story List'))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                       <div class="row">
                          <div class="col-12">
                             <div class="dashboard-title">
                                <h5>@lang('Story List')</h5>
                                <a href="{{route('user.story.create')}}" class="add-new btn-flower2 text-center">@lang('Add new')</a>
                             </div>

                             <div class="row">
                                <div class="col">
                                    <div class="table-wrapper table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">@lang('SL')</th>
                                                    <th scope="col">@lang('Name')</th>
                                                    <th scope="col">@lang('Image')</th>
                                                    <th scope="col">@lang('Privacy')</th>
                                                    <th scope="col">@lang('Status')</th>
                                                    <th scope="col">@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($storyList as $key => $value)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>@lang(\Illuminate\Support\Str::limit($value->name,20))</td>
                                                        <td>
                                                            <img src="{{ getFile(config('location.story.path').'thumb_'.$value->image)}}" alt="@lang('story img')"/>
                                                        </td>
                                                        <td>
                                                            @if ($value->privacy == 1)
                                                                <span class="status success">@lang('Public')</span>
                                                            @elseif ($value->privacy == 2)
                                                                <span class="status primary">@lang('Follower')</span>
                                                            @elseif ($value->privacy == 3)
                                                                <span class="status danger">@lang('Only Me')</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($value->status == 0)
                                                                <span class="status danger">@lang('Pending')</span>
                                                            @elseif ($value->status == 1)
                                                                <span class="status success">@lang('Approved')</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('user.story.edit',$value->id) }}">
                                                                <button class="action-btn success"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="@lang('Edit')">
                                                                    <i class="fas fa-edit fw-900"></i>
                                                                </button>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                data-route="{{ route('user.story.delete',$value->id) }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-modal"
                                                                class="action-btn danger notiflix-confirm btnDelete" >
                                                                <button class="action-btn danger"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top"
                                                                        title="@lang('Delete')">
                                                                    <i class="fas fa-trash fw-900"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="100%" class="text-center">@lang('No Story Found')</td>
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
                 </div>

            </div>
        </div>
    </section>



    <!-- Delete Modal -->
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

@endsection


@push('script')
    <script>
        'use strict'
        $(document).ready(function () {
            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });
    </script>
@endpush
