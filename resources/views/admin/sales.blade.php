@extends('_layouts.admin')
@section('css')
    <style>
        .table {
            max-width: 600px;
            margin: 0 auto;
            overflow: auto;
        }

        .pagination a {
            color: #333;
        }

        .active>.page-link, .page-link.active{
            background-color: #3f3f3f !important;
            border-color: #333;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="col-sm-12 d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <span class="mb-3">Data Sales</span>
                    <span class="mb-3">Total Sales : {{\App\Models\User::where('role', 'sales')->count()}}</span>
                </div>
                <div class="table-responsive bg-white mb-3 rounded">
                    <table class="table">
                        <thead>
                            <tr class="table table-dark">
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Total Repor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ \App\Models\Absensi::where('sales_id', $item->id)->count() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $sales->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
