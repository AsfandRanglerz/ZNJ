@extends('admin.layout.app')

@section('title', 'index')
@section('css')
<style>
.container{
    padding-top: 100px;
    width: 500px;
  }
  .col-md-2, .col-md-10{
      padding:0;
  }
  .panel{
      margin-bottom: 0px;
  }
  .chat-window{
      bottom:0;
      margin-left:10px;
  }
  .chat-window > div > .panel{
      border-radius: 5px 5px 0 0;
  }
  .icon_minim{
      padding:2px 10px;
  }
  .msg_container_base{
    background: #e5e5e5;
    margin: 0;
    padding: 0 10px 10px;
    max-height:500px;
    overflow-x:hidden;
  }
  .top-bar {
    background: #666;
    color: white;
    padding: 10px;
    position: relative;
    overflow: hidden;
  }
  .msg_receive{
      padding-left:0;
      margin-left:0;
  }
  .msg_sent{
      padding-bottom:20px !important;
      margin-right:0;
  }
  .messages {
    background: white;
    padding: 10px;
    border-radius: 2px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    max-width:100%;
  }
  .messages > p {
      font-size: 13px;
      margin: 0 0 0.2rem 0;
    }
  .messages > time {
      font-size: 11px;
      color: #ccc;
  }
  .msg_container {
      padding: 10px;
      overflow: hidden;
      display: flex;
  }
  img {
      display: block;
      width: 100%;
  }
  .avatar {
      position: relative;
  }
  .base_receive > .avatar:after {
      content: "";
      position: absolute;
      top: 0;
      right: 0;
      width: 0;
      height: 0;
      border: 5px solid #FFF;
      border-left-color: rgba(0, 0, 0, 0);
      border-bottom-color: rgba(0, 0, 0, 0);
  }

  .base_sent {
    justify-content: flex-end;
    align-items: flex-end;
  }
  .base_sent > .avatar:after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 0;
      border: 5px solid white;
      border-right-color: transparent;
      border-top-color: transparent;
      box-shadow: 1px 1px 2px rgba(black, 0.2); // not quite perfect but close
  }

  .msg_sent > time{
      float: right;
  }



  .msg_container_base::-webkit-scrollbar-track
  {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      background-color: #F5F5F5;
  }

  .msg_container_base::-webkit-scrollbar
  {
      width: 12px;
      background-color: #F5F5F5;
  }

  .msg_container_base::-webkit-scrollbar-thumb
  {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
      background-color: #555;
  }

  .btn-group.dropup{
      position:fixed;
      left:0px;
      bottom:0;
  }
</style>
@endsection
@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Price Packages</h4>

                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                {{-- <a class="btn btn-primary mb-3"
                                href="{{route('entertainer.show',$data['user_id'])}}">Back</a> --}}
                                <table class="table" id="table_chat">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($data['chat_users'] as $user)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email}}</td>
                                                <td id="role">{{ $user->role }}</td>
                                                <td
                                                style="display: flex;align-items: center;justify-content: center;column-gap: 8px">
                                                <a class="btn btn-info"
                                               href=""><i class="fa  fa-comments "></i> Chat</a>
                                                           </td>
                                                        </tr>
                                      @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
@section ('scripts')
@if (\Illuminate\Support\Facades\Session::has('message'))
<script>
    toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
</script>
@endif
<script>
    $(document).ready(function() {
        $('#table_chat').DataTable();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">

$('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
      $('.btn-info').click(function (e) {
        e.preventDefault();
        $('#role').append(`<td>
            <div class="container">
    <div class="row chat-window col-md-12" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> 청소해주세요</h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                    </div>
                </div>
                <div class="panel-body msg_container_base">
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_sent">
                                <p>청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다청소해드립니다</p>
                                <time datetime="2017-11-13T20:00">김승연 • 51 min</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_receive">
                                <p>청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요청소해주세요</p>
                                <time datetime="2017-11-13T20:00">이정재 • 51 min</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-xs-10 col-md-10">
                            <div class="messages msg_receive">
                                <p>청소해주세요</p>
                                <time datetime="2017-11-13T20:00">이정재 • 51 min</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_sent">
                        <div class="col-xs-10 col-md-10">
                            <div class="messages msg_sent">
                                <p>청소를 잘 해드립니다청소를 잘 해드립니다청소를 잘 해드립니다청소를 잘 해드립니다</p>
                                <time datetime="2017-11-13T20:00">김승연 • 51 min</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-xs-10 col-md-10">
                            <div class="messages msg_receive">
                                <p>청소를 깨끗하게 해 주세요</p>
                                <time datetime="2017-11-13T20:00">이정재 • 51 min</time>
                            </div>
                        </div>
                    </div>
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10 ">
                            <div class="messages msg_sent">
                                <p>청소를 매우 잘 합니다</p>
                                <time datetime="2017-11-13T20:00">김승연 • 51 min</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>
    		</div>
        </div>
    </div>
</div>
</td>`);


      });

</script>
@endsection
