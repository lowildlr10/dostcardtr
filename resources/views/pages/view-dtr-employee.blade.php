<div class="table-responsive-xl">
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Office</th>
                <th>Division</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if ($employees->count() > 0)
                @foreach ($employees as $key => $emp)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td align="left">
                    @if (!empty($emp->mid_name))
                        {{ strtoupper("$emp->last_name, $emp->first_name ".$emp->mid_name[0].'.') }}
                    @else
                        {{ strtoupper("$emp->last_name, $emp->first_name") }}
                    @endif
                </td>
                <td>
                    {{ $emp->office_name }}
                </td>
                <td>
                    {{ $emp->division_name }}
                </td>
                <td>
                    <button onclick="$(this).openPrintDetails({{ $emp->bio_id }});"
                            class="btn btn-link">
                        <i class="fas fa-folder-open"></i>
                        Open
                    </button>
                </td>
            </tr>
                @endforeach
            @else
            <tr>
                <td colspan="5" align="center">
                    <strong class="text-danger">
                        No employee data found.
                    </strong>
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

