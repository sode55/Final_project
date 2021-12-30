@extends('layouts.app')

@section('content')
    <table id="data-table-contact" class="table table-striped">
        <thead>
        <tr>
            <th>departure_date</th>
            <th>departure_time</th>
            <th>seat</th>
            <th>company_name</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>origin</th>
            <th>destination</th>
            <th>passenger_number</th>
            <th>totalPrice</th>
        </tr>
        </tfoot>
    </table>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            $('input[name="phone"]').mask('(000) 000-0000');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                header: {'Authentication': 'bearer "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYmUyNzc1NTU2OWQwNDZhNzkwY2IwZTA2MmI1MjIzY2ZhMzM2YmRmNWY4NjczYWNmYTE0OWRhMDdhZGU1N2E5NDQxZGU5ZDJkNDQ1ZTEyMzIiLCJpYXQiOjE2MzkwMjY0MTIuMzgzMTY2LCJuYmYiOjE2MzkwMjY0MTIuMzgzMTgxLCJleHAiOjE2NzA1NjI0MTIuMTI5OTY1LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.HelANWoddjS4uw3-j431NOcnHojDpwr-IXti2Snh-trsJ5vvZj6hA456YtxSlgfkduotbbbuZbqzt6KNOyFRqPKy4o04Wlm952Tocu2iAZCkVWHeN1_yjvA0OKZLmLLBScNeYMHuz6vI07IYMgR7R8CYXydaxnl8z6WjlQ393L59hpzJjBQ3zCXJzGqTYtFQb_D-rGkDYPQxHGG3tpaZs-gW4aRQ3JO9WAZc5p9fSuVTlph-Wx37zcBjfGMnYlqKVvdaFPu1_Say3dk8_PZl6ekq9B9J3wnD2tjBua_DRuWhY2BFQXTgMFQdtNY_fdnJ7IHHPvR3OKpoVdiaMPh7T-_bU-y6BA3NhK4dLmw8ZsaaEBsTD5wV1cZaWHJrEVy0x6QbDsqsrTTDEZodHvczOr3ZLzFEbAS3MuRV_DOgAiXbyOYN-3zuX4HOW1MbbZizgZQ7ELQkm0OdFz4Dt5PBz8ELMlArF70SVlojpxvd3jRfQ0hNFnuMkg4C5iKBmrzeJJkq18_1ubvYFfCr4rjjk9_4Hn0ndzwp3Ngj6ACx2N6xwTycfJe57kZA-OCCGnlu-tVYD872cnTAaCUJUiH2ZOXC-Yzj2hZP4G3c_W71FfbRKVsTvmd14Qg_qhadN7UZYzquP7GOMB4-i2fwGJ6mMgVfMez1JqkHGJQNPrzjsx8" '}
            });

            var dataTableTicket = $('#data-table-ticket').DataTable({
                "ordering": false,
                searching: false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: 'pdf/preview',
                    "data": function (d) {
                        var info = $('#data-table-ticket').DataTable().page.info();
                        d.page = (info.page + 1);
                    }
                },
                "columns": [
                    {"data": "departure_date"},
                    {"data": "departure_time"},
                    {"data": "origin"},
                    {"data": "destination"},
                    {"data": "seat"},
                    {"data": "passenger_number"},
                    {"data": "company_name"},
                    {"data": "totalPrice"},
                ],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }]
            });

            function ajaxRequest(url, type, data, successFunction) {
                $.ajax({
                    url: url,
                    method: type,
                    data: data,
                    success: successFunction
                });
            }
    </script>
@endsection
