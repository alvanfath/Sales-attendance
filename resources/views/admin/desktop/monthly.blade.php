@extends('_layouts.desktop')
@section('css')
    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Report Bulanan {{ $user->name }} tahun ini</h5>
                    <select name="month" id="month" class="form-select w-25">
                        @foreach ($month as $item)
                            <option value="{{$item['value']}}" {{$item['value'] == $currentMonth ? 'selected' : ''}}>{{$item['month']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table">
                            <thead class="table-info sticky-top">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Total Report</th>
                                </tr>
                            </thead>
                            <tbody id="body-table">
                                @foreach ($result as $item)
                                    <tr>
                                        <td>{{ date('d F Y', strtotime($item['date'])) }}</td>
                                        <td>{{ $item['total'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('#month').change(function () {
            var month = $(this).val();
            var url = '{{route('admin.desktop.sales.get-monthly')}}';
            $.ajax({
                type : 'get',
                url : url,
                data: {
                    month : month,
                    id : '{{$user->id}}'
                },
                cache: false,
                success: function (response) {
                    var htmlView = '';
                    for (let i = 0; i < response.length; i++) {
                        htmlView += `<tr>
                                <td>`+ response[i].date +`</td>
                                <td>`+ response[i].total +`</td>
                            </tr>`
                        $('#body-table').html(htmlView);
                    }
                }
            })
        })
    </script>
@endsection
