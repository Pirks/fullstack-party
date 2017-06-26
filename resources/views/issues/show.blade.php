@extends('layouts.master')

@section('content')

<p>
    <a href="{{ route('git.issues', [$owner, $repo]) }}">Back to issues</a>
</p>
<div class="block-wrap">
    <h2>
        {{ $issue->title }}
        <a href="{{ $issue->html_url }}" target="_blank">#{{ $issue->number }}</a>
    </h2>
    <span class="state">{{ $issue->state }}</span>
    <p class="issue-info">
        <a href="{{ $issue->user->html_url }}" target="_blank">{{ $issue->user->login }}</a> opened {{ Carbon\Carbon::parse($issue->created_at)->diffForHumans() }}
        <span class="count">{{ $issue->comments }} comment</span>        
    </p>
</div>
@foreach ($comments as $comment)
    <div class="block-wrap">
        <h4>
            <a href="{{ $comment->user->html_url }}" target="_blank">{{ $comment->user->login }}</a>
            commetned {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
        </h4>
        <hr/>
        <p>
            {{ $comment->body }}
        </p>
    </div>
@endforeach

@stop