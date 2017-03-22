@extends('layouts.app')

@section('content')
<style>
    #users {
        font-size: 1em;
        border-spacing: 0;
        border-collapse: collapse;
    }

    #users tr td {
        padding: 0px;
    }

</style>
<div class="row">
    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-body">
                <table id="users" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Meno</th>
                        <th>Email</th>
                        <th>Heslo</th>
                        <th>Editácia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}} </td>
                            <td>{{$user->email}}</td>
                            <td>
                                <form method="POST" action="{{ route('password.email') }}">
                                    {{ csrf_field() }}
                                    <input id="email" type="hidden" name="email" value="{{$user->email}}">
                                    <button type="submit" class="btn-xs fa fa-refresh">
                                    </button>
                                </form>
                            </td>
                            <td align="right">
                                <a href="/users/show/{{$user->id}}" title="Užívatelské role"><i class="ion ion-ios-keypad" aria-hidden="true"></i></a>
                                <a href="/enumeration/destroy/{{$user->id}}" title="Zmazanie užívateľa"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($roles!='')
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Užívatelské role > {{$user_akt->name}}</h3>
            </div>
            <div class="box-body">
                <form action="/users/updateRole/{{$user_akt->id}}" method="post" role="form" id="form_role">
                    {{ csrf_field() }}
                    @foreach($roles as $role)
                    <div class="col-md-6">
                        <input type="checkbox" name="id{{$cnt++}}" value="{{$role->id}}"
                        @foreach($user_role as $role_id)
                            @if($role_id->role_id == $role->id)
                                checked
                            @endif
                        @endforeach
                        > {{$role->description}}
                    </div>
                    @endforeach
                    <div class="col-md-12">
                        <input type="hidden" name="cnt" value="{{count($roles)}}">
                        <button type="submit" class="btn btn-primary" id="btn_pridat">Zmeniť</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-4">
        @foreach($items as $item)
            <!-- small box -->
            <div class="small-box {{$item['color']}}">
                <div class="inner">
                    <h3>{{$item['menu_name']}}</h3>
                </div>
                <div class="icon">
                    <i class="ion {{$item['ion']}}"></i>
                </div>
                <a href="{{$item['url']}}" class="small-box-footer">Zobraz <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        @endforeach
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Registácia</h3>
            </div>
            <div class="box-body">
                <form action="/users" method="post" role="form" id="form_user">
                    {{ csrf_field() }}
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label>Meno</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" maxlength="255" required autofocus>
                        @if ($errors->has('name'))
                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        <label>Email</label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control" maxlength="255" required>
                        @if ($errors->has('email'))
                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                        <label>Heslo</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('valid_from') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
                        <label>Potvrdenie hesla</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn_pridat">Registrácia</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- DataTables -->
<script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>

    $(function () {

        $("#users").DataTable({
            fixedHeader: false,
            "language":
            {
                "decimal":        "",
                "emptyTable":     "Dáta pre tabuľku nie sú dostupné",
                "info":           "Zobrazujem od _START_ po _END_ z _TOTAL_ záznamov",
                "infoEmpty":      "Zobrazujem od 0 po 0 z 0 záznamov",
                "infoFiltered":   "(vyfiltrované z _MAX_ celkových záznamov)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Zobrazenie _MENU_ záznamov",
                "loadingRecords": "Načítavam...",
                "processing":     "Spracúvam...",
                "search":         "Vyhľadávanie: ",
                "zeroRecords":    "Nenašli sa žiadne zhodujúce sa záznamy",
                "paginate": {
                    "first":      "Prvý",
                    "last":       "Posledný",
                    "next":       "Ďalší",
                    "previous":   "Predošlý"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            "aaSorting": [],
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "js/datatables/tools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [
                    "copy",
                    "csv"
                ]
            },
            "columnDefs": [
                {
                    "targets": [2, 3],
                    "orderable": false
                }
            ],
            paging:         false,
            "order": [[ 0, "asc" ]]
        });


    });
</script>

@endsection
