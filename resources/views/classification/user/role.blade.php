@extends('layouts.app')

@section('content')
<style>
    #role {
        font-size: 1em;
        border-spacing: 0;
        border-collapse: collapse;
    }

    #role tr td {
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
                <table id="role" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Názov</th>
                        <th>Skratka</th>
                        <th>Popis</th>
                        <th>Editácia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{$role->display_name}}</td>
                        <td>{{$role->name}} </td>
                        <td>{{$role->description}}</td>
                        <td align="right">
                            <a href="/role/show/{{$role->id}}" title="Užívatelské práva"><i class="ion ion-checkmark-round" aria-hidden="true"></i></a>
                            <a style="cursor:pointer;" id="edit_item{{$role->id}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($permissions!='')
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Užívatelské práva > {{$role_akt->display_name}}</h3>
                </div>
                <div class="box-body">
                    <form action="/role/updatePermission/{{$role_akt->id}}" method="post" role="form" id="form_role">
                        {{ csrf_field() }}
                        @foreach($permissions as $permission)
                            <div class="col-md-6">
                                <input type="checkbox" name="id{{$cnt++}}" value="{{$permission->id}}"
                                @foreach($permission_role as $permission_id)
                                    @if($permission_id->permission_id == $permission->id)
                                        checked
                                    @endif
                                @endforeach
                                > {{$permission->description}}
                            </div>
                        @endforeach
                        <div class="col-md-12">
                            <input type="hidden" name="cnt" value="{{count($permissions)}}">
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
                <h3 class="box-title" id="nadpis">Pridanie záznamu</h3>
            </div>
            <div class="box-body">
                <form action="/role" method="post" role="form" id="form_role">
                    {{ csrf_field() }}
                    <div class="form-group @if ($errors->has('name')) has-error @endif" id="div_name">
                        <label>Skratka</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" maxlength="255">
                        @if ($errors->has('name'))
                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('shortname')) has-error @endif">
                        <label>Názov</label>
                        <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" class="form-control" maxlength="255">
                        @if ($errors->has('display_name'))
                        <span class="help-block"><strong>{{ $errors->first('display_name') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                        <label>Popis</label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}" class="form-control" maxlength="255">
                        @if ($errors->has('description'))
                        <span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
                        @endif
                    </div>
                    <input type="hidden" name="id" id="id" value="">
                    <button type="submit" class="btn btn-primary" id="btn_pridat">Pridať</button>
                </form>
            </div>
        </div>
        <div class="small-box bg-green" style="display: none;" id="add_new">
            <div class="inner">
                <h3><br>Nový záznam<br></h3>
            </div>
            <div class="icon">
                <i class="ion ion-plus-round"></i>
            </div>
        </div>
    </div>
</div>
<!-- DataTables -->
<script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset ('/bower_components/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
    @foreach($roles as $role)
    $("#edit_item{{$role->id}}").click(function() {
        $("#div_name").hide();
        $("#add_new").show();
        $("#add_new").show();
        $("#nadpis").text("Zmena záznamu");
        $("#name").val('{{$role->name}}');
        $("#display_name").val('{{$role->display_name}}');
        $("#description").val('{{$role->description}}');
        $("#id").val('{{$role->id}}');
        $("#form_role").attr("action", "/role/update/{{$role->id}}");
        $("#btn_pridat").text("Uložiť");
    });
    @endforeach

    $("#add_new").click(function() {
        $("#div_name").show();
        $("#add_new").hide();
        $("#nadpis").text("Pridanie záznamu");
        $("#display_name").val('');
        $("#description").val('');
        $("#id").val('');
        $("#form_permission").attr("action", "/role");
        $("#btn_pridat").text("Pridať");
    });

    $(function () {

        $("#role").DataTable({
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
                    "targets": 3,
                    "orderable": false
                }
            ],
            paging:         false,
            "order": [[ 0, "asc" ]]
        });


    });
</script>

@endsection
