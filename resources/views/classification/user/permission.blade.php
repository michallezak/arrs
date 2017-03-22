@extends('layouts.app')

@section('content')

<style>
    #permission {
        font-size: 1em;
        border-spacing: 0;
        border-collapse: collapse;
    }

    #permission tr td {
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
                <table id="permission" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Popis</th>
                        <th>Skratka</th>
                        <th>Názov</th>
                        <th>Editácia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{$permission->description}}</td>
                        <td>{{$permission->name}} </td>
                        <td>{{$permission->display_name}}</td>
                        <td align="right">
                            <a style="cursor:pointer;" id="edit_item{{$permission->id}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title" id="nadpis">Pridanie záznamu</h3>
            </div>
            <div class="box-body">
                <form action="/permission" method="post" role="form" id="form_permission">
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
    @foreach($permissions as $permission)
    $("#edit_item{{$permission->id}}").click(function() {
        $("#div_name").hide();
        $("#add_new").show();
        $("#nadpis").text("Zmena záznamu");
        $("#display_name").val('{{$permission->display_name}}');
        $("#description").val('{!!$permission->description!!}');
        $("#id").val('{{$permission->id}}');
        $("#form_permission").attr("action", "/permission/update/{{$permission->id}}");
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
        $("#form_permission").attr("action", "/permission");
        $("#btn_pridat").text("Pridať");
    });

    $(function () {

        $("#permission").DataTable({
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
