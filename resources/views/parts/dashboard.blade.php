<div class="card-header">{{ __('Dashboard') }}</div>

<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif



    <div class="row " id="dashboard_cabinet" >
        @foreach($cabinets as $cabinet)
           <div class="col-lg-4 {{'cabinet' . $cabinet->id}}" >
               <div class="card mb-2 text-white {{$cabinet->background}}" >
                   <div class="card-body text-center">
                       <h5 class="card-title">{{$cabinet->name}}</h5>
                   </div>
               </div>
               <button data-cabinet="{{$cabinet->id}}"  class="btn book_btn d-block btn-success m-auto">Забронировать</button>
           </div>
        @endforeach
    </div>

    <button id="modal_book" class="d-none" data-toggle="modal" data-target="#exampleModal"></button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-sm-between">
                                <label class="m-0 mr-2" for=""> Дата</label>
                                <input id="cabinet_id" type="hidden"  placeholder="">
                                <input id="user_id" type="hidden" value="{{auth()->id()}}"  placeholder="">
                                <input id="schedule_date" type="date" class="form-control w-75" placeholder="Date">
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-sm-between">
                                <label class="m-0 mr-2" for=""> От</label>
                                <input id="schedule_from" type="time" class="form-control w-75" placeholder="From">
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-sm-between">
                                <label class="m-0 mr-2" for="">До</label>
                                <input id="schedule_to" type="time" class="form-control w-75" placeholder="to">
                            </div>
                            <div class="col mt-3 text-right">
                                <button id="schedule_book" class="btn btn-success">Забронировать </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

</div>
<script type="application/javascript">

        $("body").on("click", ".book_btn", function(){

            let cabinet_id = $(this).data("cabinet");
            $('#cabinet_id').val(cabinet_id)
            $('#modal_book').click();


        });



        $("body").on("click", "#schedule_book", function() {
            var url = "{{url('/api/schedule')}}";
            var formData = new FormData();
            formData.append('date', $('#schedule_date').val());
            formData.append('to', $('#schedule_to').val());
            formData.append('from', $('#schedule_from').val());
            formData.append('cabinet_id',$('#cabinet_id').val());
            formData.append('user_id',$('#user_id').val());


            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    $('.modal-footer').html(' ')
                    if(response.message.length != 0) {
                        let notification = '<div class="alert alert-success m-3" role="alert"><h5>' +
                            response.message.title+'</h5><p>' +
                            response.message.message  +'</p></div>';
                        $('#notifications').prepend(notification)
                        $('#notification_count').removeClass('d-none')
                    }
                    if (response.status == 1) {

                        const respMess =  '<ul class="bg-success text-white list-group w-100 p-2">' + '<h5>Успешно забронировали кабинет </h5>'
                            + '</li>'
                            + '<li>Начальное время : ' +
                            response.schedule.date + ' ' + response.schedule.from
                            + '</li>'
                            + '<li>Время окончания : ' +
                            response.schedule.date + ' ' + response.schedule.to
                            + '</li></ul>';
                        $('.modal-footer').append(respMess)

                    } else {
                        const respMess =  '<ul class="bg-danger text-white list-group w-100 p-2">' +
                            '<h5>Кабинет уже забронирован </h5>'
                            + '<li>Имя : ' +
                            response.schedule.user.name
                            + '</li>'
                            + '<li>Эл. адрес : ' +
                            response.schedule.user.email
                            + '</li>'
                            + '<li>Начальное время : ' +
                             response.schedule.date + ' ' + response.schedule.from
                            + '</li>'
                            + '<li>Время окончания : ' +
                             response.schedule.date + ' ' + response.schedule.to
                            + '</li>' +
                            '</ul>';
                        $('.modal-footer').append(respMess)

                    }
                    setTimeout(function(){
                        $('.modal-footer').html(' ')
                    }, 10000);//w

                },
                error: function (response) {
                    let itMess = '';
                    $.each( response.responseJSON, function( index, value ){

                        itMess  += '<li>' + index + ' ' + value[0] + '</li>';
                    });
                    const errMess = '<ul class="bg-danger text-white list-group w-100 p-2">' +
                        itMess
                    +'</ul>';
                   $('.modal-footer').append(errMess)
                    setTimeout(function(){
                        $('.modal-footer').html(' ')
                    }, 10000);//w
                }
            },)
        })

</script>
