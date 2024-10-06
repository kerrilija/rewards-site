@extends('layouts.layout')

@section('title', 'Contributions')

@section('content')
    <h2>Contributions</h2>
    <table>
        <thead>
            <tr>
                <th>Contributor</th>
                <th>Contribution</th>
                <th>Reward</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($contributions as $contribution)
            <tr>
                <td>{{ $contribution->contributor->name ?? 'Unknown' }}</td>
                <td>{{ $contribution->type }}</td>
                <td>{{ number_format($contribution->reward, 2) }} damo</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No contributions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
