@extends('layouts.app')

@section('content')


    <script>
        $(function () {
            $("#JRequest").click(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "GET",
                    url: '/view-comments',
                    dataType: "json",
                    success: function (data) {
                        $.each(data.data, function (i, data) {
                            console.log(data.data);
                            console.log(data.comments);
                        });
                    }
                });
            })
        });
    </script>
@endSection
