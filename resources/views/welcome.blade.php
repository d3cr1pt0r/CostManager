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

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- Static navbar -->
        <nav class="navbar navbar-inverse navbar-static-top" style="margin-bottom: 0;">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">CostManager</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar-fixed-top/">All</a></li>
                <li><a href="../navbar/">Costs</a></li>
                <li class="active"><a href="./">Profit<span class="sr-only">(current)</span></a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>


        <div class="container-fluid">
            @if (Session::has('message'))
                <div class="bs-example bs-example-standalone" data-example-id="dismissible-alert-js">
                    <div class="alert alert-warning alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                            <form class="form" action="add-profit" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Name</div>
                                        <input type="text" class="form-control" id="name" placeholder="Sticker foil, Gasoline, ...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">$</div>
                                        <input type="text" class="form-control" id="amount" placeholder="Amount">
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
                            <form class="form" action="add-expense" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">Name</div>
                                        <input type="text" class="form-control" id="name" placeholder="Sticker foil, Gasoline, ...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="min-width: 60px; max-width:60px;">$</div>
                                        <input type="text" class="form-control" id="amount" placeholder="Amount">
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <button type="submit" class="btn btn-danger" style="width:100%;">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </body>
</html>
