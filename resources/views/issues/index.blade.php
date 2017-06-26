@extends('layouts.master')

@section('content')

<h1>Issues</h1>
{{ $openCount }} Open. {{ $closeCount }} Closed.
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Labels</th>
            <th>Author</th>
            <th>Opened</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($issues as $issue)
            <tr>
                <td><a href="{{ route('git.issue', [$owner, $repo, $issue->number]) }}">{{ $issue->number }}</a></td>
                <td>{{ $issue->title }}</td>
                <td>
                    {{ collect($issue->labels)->implode('name', ', ') }}
                </td>
                <td>{{ $issue->user->login }}</td>
                <td>{{ Carbon\Carbon::parse($issue->created_at)->diffForHumans() }}</td>
                <td>{{ $issue->comments }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $issues->links() }}

@stop