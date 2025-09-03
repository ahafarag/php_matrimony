@extends($theme.'layouts.user')
@section('title',__($page_title))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="dashboard-title">
                           <h5>
                                {{__($page_title)}}
                           </h5>
                        </div>
                        <div class="message-wrapper">
                           <div class="row g-md-0">
                              <div class="col-md-12">
                                 <div class="inbox-wrapper">
                                    <!-- top bar -->
                                    <div class="top-bar">
                                       <div>
                                            {{-- <h5> --}}
                                                @if($ticket->status == 0)
                                                    <span class="status">@lang('Open')</span>
                                                @elseif($ticket->status == 1)
                                                    <span class="status primary">@lang('Answered')</span>
                                                @elseif($ticket->status == 2)
                                                    <span class="status danger">@lang('Customer Reply')</span>
                                                @elseif($ticket->status == 3)
                                                    <span class="status dark">@lang('Closed')</span>
                                                @endif
                                                [{{trans('Ticket#'). $ticket->ticket }}] {{ $ticket->subject }}
                                            {{-- </h5> --}}
                                       </div>

                                       <div>
                                            <button type="button" class="btn btn-sm closeBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#closeTicketModal"> <i class="fas fa-times-circle text-white font14"></i> {{trans('Close')}}
                                            </button>
                                        </div>
                                    </div>

                                    <!-- chats -->
                                    @if(count($ticket->messages) > 0)
                                        <div class="chats">
                                            @foreach($ticket->messages as $item)
                                                @if($item->admin_id == null)
                                                    <div class="chat-box this-side">
                                                        <div class="text-wrapper d-block w-100">
                                                            <p class="text-end p-0 m-0">@lang(optional($ticket->user)->username)</p>
                                                            <div class="text">
                                                                <p>{{$item->message}}</p>
                                                            </div>
                                                            <div class="fileShow d-flex justify-content-end my-1">
                                                                @if(0 < count($item->attachments))
                                                                    @foreach($item->attachments as $k=> $image)
                                                                        <a
                                                                            href="{{route('user.ticket.download',encrypt($image->id))}}"
                                                                            class="attachment me-2"
                                                                        >
                                                                            <i class="fa fa-file font14"></i> @lang('File') {{++$k}}
                                                                        </a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <span class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
                                                        </div>
                                                        <div class="img">
                                                            <img class="img-fluid" src="{{getFile(config('location.user.path').optional($ticket->user)->image)}}" alt="@lang('user image')"/>
                                                        </div>
                                                    </div>

                                                @else
                                                    <div class="chat-box opposite-side">
                                                        <div class="img">
                                                            <img class="img-fluid" src="{{getFile(config('location.admin.path').optional($item->admin)->image)}}" alt="@lang('admin image')"/>
                                                        </div>
                                                        <div class="text-wrapper d-block w-100">
                                                            <p class="text-start p-0 m-0">@lang(optional($item->admin)->name)</p>
                                                            <div class="text">
                                                                <p>{{$item->message}}</p>
                                                            </div>
                                                            <div class="fileShow d-flex justify-content-start my-1">
                                                                @if(0 < count($item->attachments))
                                                                    @foreach($item->attachments as $k=> $image)
                                                                        <a
                                                                            href="{{route('user.ticket.download',encrypt($image->id))}}"
                                                                            class="attachment me-2"
                                                                        >
                                                                            <i class="fa fa-file font14"></i> @lang('File') {{++$k}}
                                                                        </a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <span class="time">{{dateTime($item->created_at, 'd M, y h:i A')}}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif


                                    <!-- typing area -->
                                    <form action="{{ route('user.ticket.reply', $ticket->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="typing-area">
                                            <div class="input-group">
                                                <div>
                                                    <button class="upload-img send-file-btn">
                                                        <i class="fal fa-paperclip text-white me-2"></i>
                                                        <input
                                                            class="form-control"
                                                            name="attachments[]"
                                                            id="upload"
                                                            type="file"
                                                            multiple
                                                            placeholder="@lang('Upload File')"
                                                            onchange="previewImage('attachment')"
                                                        />
                                                    </button>
                                                </div>
                                                <textarea name="message" cols="30" rows="10" class="form-control" placeholder="@lang('Type Here...')">{{old('message')}}</textarea>

                                                <button type="submit" name="replayTicket" value="1" class="submit-btn text-white">
                                                    <i class="fal fa-paper-plane"></i>
                                                </button>
                                            </div>
                                            @error('message')
                                                <span class="text-danger">{{trans($message)}}</span>
                                            @enderror
                                            <p class="name text-danger select-files-count mt-1"></p>
                                        </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Close Ticket Modal -->
    <div id="closeTicketModal" class="modal fade modal-with-form" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content form-block">
                <form action="{{ route('user.ticket.reply', $ticket->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                            <h5 class="modal-title">@lang('Ticket Close Confirmation')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>@lang('Are you sure to close this?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-flower2 btn1" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" name="replayTicket" value="2" class="btn-flower2 btn2">@lang('Confirm')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


@push('script')
    <script>
        'use strict';
        $(document).on('change', '#upload', function () {
            var fileCount = $(this)[0].files.length;
            $('.select-files-count').text(fileCount + ' file(s) selected')
        })

        $(document).ready(function () {
            $('.close').on('click', function (e) {
                $("#closeTicketModal").modal("hide");
            });

            const previewImage = (id) => {
                document.getElementById(id).src = URL.createObjectURL(
                    event.target.files[0]
                );
            };
        });
    </script>
@endpush
