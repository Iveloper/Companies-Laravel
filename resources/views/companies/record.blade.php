@extends('layouts.app')

@section('content')

<table class="table table-striped">
    <thead>
    <th>ID</th>
    <th>{{trans('company.name')}}</th>
    <th>{{trans('company.adress')}}</th>
    <th>{{trans('company.bulstat')}}</th>
    <th>{{trans('company.email')}}</th>
    <th>{{trans('company.phone')}}</th>
    <th>{{trans('company.contragent_type')}}</th>
    <th>{{trans('company.note')}}</th>
</thead>

<tbody>
    @foreach ($view as $record)

    <tr style="background-color: lightgrey">
        <td>{{ $record->id }}</td>
        <td>{{ $record->name }}</td>
        <td>{{ $record->adress }}</td>
        <td>{{ $record->bulstat }}</td>
        <td>{{ $record->email }}</td>
        <td>{{ $record->phone }}</td>
        <td>{{ $record->contragent }}</td>

        <td>{{ $record->note }}</td>
    </tr>

    @endforeach
</tbody>
</table>

<div id="myModal" class="modal" style="display: none;">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times; </span>
        <h3 style="text-align: center;">All people working in {{$view[0]->name}}: </h3>

        <table class="table table-striped" style="width:100%;">
            <thead>
            <th>{{trans('company.name')}}</th>
            <th>{{trans('company.adress')}}</th>
            <th>{{trans('company.birthday')}}</th>
            <th>{{trans('company.email')}}</th>
            <th>{{trans('company.phone')}}</th>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>

</div>
<button name="{{ $companyID }}" type="button" class="btn btn-info" id="showPeople" style="width:100%; margin-bottom: 10px;">{{trans('company.people')}}</button>
<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary" style="width:100%;">{{trans('company.goBack')}}</button></a>


<script>

    $("#showPeople").click(function (event) {
        event.preventDefault();
        var token = $('input[name="_token"]').val();
        $.ajax({
            type: 'GET',
            url: "/people/people",
            data: {
                id: $(this).attr("name"),
                _token: token
            },
            success: function (data) {
                $(".modal-content table tbody").empty();
                $(data).each(function (index, value) {
                    console.dir(value.id);
                    $("#myModal").attr('style', 'display: block');
                    
                    $(".modal-content table tbody").append($('<tr><td>'
                            + value.name +
                            '</td><td >'
                            + value.adress +
                            '</td><td >'
                            + value.date_of_birth +
                            '</td><td >'
                            + value.email +
                            '</td><td >'
                            + value.phone +
                            '</td></tr>'));
                });
            },

        });

        $(".close").click(function (event) {

            $("#myModal").attr('style', 'display: none');
        });
    });

</script>

@endsection