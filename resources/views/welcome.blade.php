<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CostManager - Luka Ložar s.p.</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

        <!-- Bootstrap datepicker -->
        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap-datepicker.css') }}">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-static-top" style="margin-bottom: 0;">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    @if ($balance >= 0)
                        <a class="navbar-brand" href="#">Balance: <span style="color: #5cb85c; font-size: 18px;">{{ $balance }}€</span></a>
                    @else
                        <a class="navbar-brand" href="#">Balance: <span style="color: #d9534f; font-size: 18px;">{{ $balance }}€</span></a>
                    @endif
                </div>
                <form action="{{ URL::to('/set-date-range') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li style="margin-top: 10px;">
                                <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" name="start" style="width: 100px;" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="input-sm form-control" name="end" style="width: 100px;" />
                                </div>
                            </li>
                            <li style="margin-left: 5px; margin-right: 5px;">
                                <button class="btn btn-default" style="line-height: 16px; margin-top: 10px;">Show</button>
                            </li>
                            <li class="active"><a href="{{ URL::to('/') }}">All</a></li>
                            <li><a href="{{ URL::to('/weekly') }}">Week</a></li>
                            <li><a href="{{ URL::to('/monthly') }}">Month</a></li>
                            <li><a href="{{ URL::to('/yearly') }}">Year<span class="sr-only">(current)</span></a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </nav>

        <div class="container-fluid">
            @if (Session::has('message'))
                <div class="bs-example bs-example-standalone" data-example-id="dismissible-alert-js" style="text-align: center;">
                    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="margin: 10px 0 0 0; padding: 4px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="top: 0px; right: 0px;"><span aria-hidden="true">&times;</span></button>
                        <strong>Message: </strong> {{ Session::get('message') }}
                </div>
            @endif
            <div class="row" style="padding-top: 20px;">
                <div class="col-md-6">
                    <div class="panel panel-success" style="float: left;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add profit</h3>
                        </div>
                        <div class="panel-body">
                            <div style="margin-bottom: 10px;">
                                @foreach ($profit_traffic_types as $traffic_type)
                                    <a href="#!" class="profit-quick-add"><span class="label label-primary">{{ $traffic_type->name }}</span></a>
                                @endforeach
                            </div>
                            <form class="form" action="{{ URL::to('/add-profit') }}" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Name</div>
                                        <input type="text" class="form-control name-profit-ac" name="name" data-provide="typeahead" autocomplete="off" placeholder="Payment, ...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Desc</div>
                                        <input type="text" class="form-control" name="desc" autocomplete="on" placeholder="Enter description here...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">€</div>
                                        <input type="number" step="any" class="form-control amount-profit" name="amount" placeholder="Amount">
                                    </div>
                                </div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Extra-small button group" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">+1</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">+5</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">+10</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">+50</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">+100</button>
                                </div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Extra-small button group" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">-1</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">-5</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">-10</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">-50</button>
                                    <button type="button" class="btn btn-default quick-amount-profit" style="width: 50px;">-100</button>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-success" style="width:100%;">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-danger" style="float: left;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Add expense</h3>
                        </div>
                        <div class="panel-body">
                            <div style="margin-bottom: 10px;">
                                @foreach ($expense_traffic_types as $traffic_type)
                                    <a href="#!" class="expense-quick-add"><span class="label label-primary">{{ $traffic_type->name }}</span></a>
                                @endforeach
                            </div>
                            <form class="form" action="{{ URL::to('/add-expense') }}" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Name</div>
                                        <input type="text" class="form-control name-expense-ac" name="name" data-provide="typeahead" autocomplete="off" placeholder="Sticker foil, Gasoline, ...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Desc</div>
                                        <input type="text" class="form-control" name="desc" autocomplete="on" placeholder="Enter description here...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">€</div>
                                        <input type="number" step="any" class="form-control amount-expense" name="amount" placeholder="Amount">
                                    </div>
                                </div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Extra-small button group" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">+1</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">+5</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">+10</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">+50</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">+100</button>
                                </div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Extra-small button group" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">-1</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">-5</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">-10</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">-50</button>
                                    <button type="button" class="btn btn-default quick-amount-expense" style="width: 50px;">-100</button>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger" style="width:100%;">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @include('chart')
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($traffic as $t)
                                <tr class="{{ $t->trafficType->is_cost == 1 ? "danger" : "success"  }}" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $t->trafficType->desc  }}">
                                    <th>{{ $t->trafficType->name }}</th>
                                    <td>{{ date("d.m.Y [H:i]", strtotime($t->created_at)) }}</td>
                                    <td>{{ $t->amount }}</td>
                                    <td>
                                        <a href="{{ URL::to('/remove-traffic/'.$t->id) }}" class="delete-entry">Delete</a>
                                        <a href="#!" class="edit-entry" data-toggle="modal" data-target=".bs-example-modal-sm" traffic-id="{{ $t->trafficType->id }}" traffic-name="{{ $t->trafficType->name }}" traffic-desc="{{ $t->trafficType->desc }}" traffic-amt="{{ $t->amount }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit modal -->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="padding: 30px 20px 30px 20px;">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Name</div>
                            <input type="text" class="form-control name-profit-ac" id="input-traffic-name" data-provide="typeahead" autocomplete="off" placeholder="Payment, ...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Desc</div>
                            <input type="text" class="form-control"  id="input-traffic-desc" autocomplete="on" placeholder="Enter description here...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon" style="min-width: 60px; max-width:60px;">€</div>
                            <input type="number" step="any" class="form-control amount-profit"  id="input-traffic-amt" placeholder="Amount">
                        </div>
                    </div>
                    <button class="btn btn-success" style="width:100%;" id="input-traffic-update">Update</button>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Canvas JS -->
        <script src="{{ URL::asset('assets/js/canvasjs-1.7.0/jquery.canvasjs.min.js') }}"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <!-- Bootstrap 3 autocomplete -->
        <script src="{{ URL::asset('assets/js/bootstrap3-autocomplete.js') }}"></script>

        <!-- Bootstrap 3 datepicker -->
        <script src="{{ URL::asset('assets/js/bootstrap-datepicker.js') }}"></script>

        <script>
            var traffic_id = null;
            var traffic_name = null;
            var traffic_desc = null;
            var traffic_amt = null;

            // Init datepicker
            $('#navbar .input-daterange').datepicker({
                format: "dd.mm.yyyy",
                todayBtn: "linked"
            });

            // Ajax request for traffic types for autocomplete
            $.get("{{ URL::to('/ajax/traffic-types-profit') }}", function( data ) {
                data = JSON.parse(data);
                $(".name-profit-ac").typeahead({ source: data });
            });
            $.get("{{ URL::to('/ajax/traffic-types-expense') }}", function( data ) {
                data = JSON.parse(data);
                $(".name-expense-ac").typeahead({ source: data });
            });

            // Quick add for cost name
            $(".profit-quick-add").click(function() {
                $(".name-profit-ac").val($(this).text());
            });
            $(".expense-quick-add").click(function() {
                $(".name-expense-ac").val($(this).text());
            });

            // Quick amount increase/decrease
            $(".quick-amount-profit").click(function() {
                var str = $(this).text();
                var prefix = str.charAt(0);
                var num = Number(str.slice(1, str.length));
                var cur_val = $(".amount-profit").val();

                if (cur_val == "") cur_val = 0;
                else cur_val = Number(cur_val);

                if (prefix == '+') cur_val += num;
                if (prefix == '-') cur_val -= num;

                $(".amount-profit").val(cur_val);
            });
            $(".quick-amount-expense").click(function() {
                var str = $(this).text();
                var prefix = str.charAt(0);
                var num = Number(str.slice(1, str.length));
                var cur_val = $(".amount-expense").val();

                if (cur_val == "") cur_val = 0;
                else cur_val = Number(cur_val);

                if (prefix == '+') cur_val += num;
                if (prefix == '-') cur_val -= num;

                $(".amount-expense").val(cur_val);
            });

            // Prevent accidental entry removal
            $(".delete-entry").click(function(e) {
                if (!confirm("Do you really wish to delete?")) {
                    e.preventDefault();
                }
            });

            $(".edit-entry").click(function(e) {
                //e.stopPropagation();
                traffic_id = $(this).attr("traffic-id");
                traffic_name = $(this).attr("traffic-name");
                traffic_desc = $(this).attr("traffic-desc");
                traffic_amt = $(this).attr("traffic-amt");

                $("#input-traffic-name").val(traffic_name);
                $("#input-traffic-desc").val(traffic_desc);
                $("#input-traffic-amt").val(traffic_amt);
            });

            $("#input-traffic-update").click(function() {
                traffic_name = $("#input-traffic-name").val();
                traffic_desc = $("#input-traffic-desc").val();
                traffic_amt = $("#input-traffic-amt").val();

                $.post( "{{ URL::to('/ajax/update-traffic') }}", { traffic_id: traffic_id, traffic_name: traffic_name, traffic_desc: traffic_desc, traffic_amt: traffic_amt }).done(function( data ) {
                    if (data == "OK") {
                        location.reload();
                    }
                    else {
                        alert("Failed to update!");
                    }
                });
            });

            $(".danger, .success").popover();
        </script>
    </body>
</html>