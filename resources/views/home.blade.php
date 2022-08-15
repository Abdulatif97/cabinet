@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="list-group"  id="nav-tab" role="tablist">
                <a  class="list-group-item list-group-item-action active"
                   id="nav-dashboard-tab" data-toggle="tab" href="#nav-dashboard" role="tab"
                   aria-controls="nav-dashboard" aria-selected="true">
                    Dashboard
                </a>
                <a  class="list-group-item list-group-item-action"
                   id="nav-cabinets-tab" data-toggle="tab" href="#nav-cabinets"
                   role="tab" aria-controls="nav-cabinets" aria-selected="true"
                >Cabinets</a>
                <a  class="list-group-item list-group-item-action"
                   id="nav-notification-tab" data-toggle="tab" href="#nav-notification"
                   role="tab" aria-controls="nav-notification" aria-selected="true">Notifications
                    <span id="notification_count" class="d-none position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden"></span>
                    </span>
                </a>
            </div>

        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-dashboard" role="tabpanel" aria-labelledby="nav-dashboard-tab">
                        @include('parts.dashboard')

                    </div>
                    <div class="tab-pane fade" id="nav-cabinets" role="tabpanel" aria-labelledby="nav-cabinets-tab">
                        @include('parts.cabinet')
                    </div>
                    <div class="tab-pane fade" id="nav-notification" role="tabpanel" aria-labelledby="nav-notification-tab">
                        @include('parts.notification')
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
@endsection
<script type="application/javascript">


</script>
