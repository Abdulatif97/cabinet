<div class="card-header">Cabinets</div>

<div class="card-body">

    <form class="card-header mb-5 needs-validation">
        <div class="form-group">
            <label for="cabinet_name">Cabinet Name</label>
            <input class="form-control" id="cabinet_name" required type="text" placeholder="Cabinet name">
            <div class="invalid-feedback">
                Please provide a valid city.
            </div>
        </div>
        <div class="form-group">
            <label for="background">Background</label>
            <select class="form-control" required id="background">
                <option value="bg-primary">.bg-primary</option>
                <option value="bg-secondary">.bg-secondary</option>
                <option value="bg-success">.bg-success</option>
                <option value="bg-danger">.bg-danger</option>
                <option value="bg-warning">.bg-warning</option>
                <option value="bg-info">.bg-info</option>
                <option value="bg-light">.bg-light</option>
            </select>
        </div>

        <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Background</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody id="cabinetTbody">
            @foreach($cabinets as $cabinet)
            <tr class="{{'cabinet' . $cabinet->id}}">
                <th scope="row">{{$cabinet->id}}</th>
                <td>{{$cabinet->name}}</td>
                <td class="{{$cabinet->background}}"> .{{$cabinet->background}}</td>
                <td class=""> <button data-cabinet="{{$cabinet->id}}" class="delete-cabinet btn btn-danger">Delete</button></td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
<script type="application/javascript">
    window.onload = function () {
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $('.delete-cabinet').click(function(){
            let cabinet_id = $(this).data("cabinet");

            var url = "{{url('/api/cabinet/')}}";
            var formData = new FormData();


            $.ajax({
                url: url + '/' +cabinet_id,
                type: "DELETE",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    $( ".cabinet" +  cabinet_id).remove();
                }
            },)

        });



        $('#submitBtn').click(function(e){
            e.preventDefault()
            //Some code
            if ($('#cabinet_name').val().length > 0 && $('#background').val().length > 0) {
                var url = "{{url('/api/cabinet')}}";
                var formData = new FormData();
                formData.append('name', $('#cabinet_name').val());
                formData.append('background', $('#background').val());
                formData.append('api_token', '{{Auth::user()->api_token}}');


                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        $('#cabinet_name').val(null)
                        let item = '<tr> <th scope="row">' +
                            response.data.id +
                            '</th> <td>' +
                            response.data.name +
                            '</td> <td class="' +
                            response.data.background
                            +
                            '">' +
                            response.data.background
                            +
                            '</td>  <td class=""> <button data-cabinet="' +
                            response.data.id +
                             '" class="delete-cabinet btn btn-danger">Delete</button></td> </tr>',
                        homeItem = '    <div class="col-lg-4 ' +
                            'cabinet' + response.data.id
                            +'" > <div class="card mb-2 text-white ' +
                            response.data.background
                            +'" > <div class="card-body text-center"> <h5 class="card-title">' +
                            response.data.name  +'</h5> </div> </div> <button data-cabinet="' +
                            response.data.id
                            +'" class="btn d-block btn-success m-auto book_btn"   >Забронировать</button> </div>'
                        ;


                        $('#cabinetTbody').append(item);
                        $('#dashboard_cabinet').append(homeItem);
                    }
                },)
                    ;
            }

        })

    }

</script>
