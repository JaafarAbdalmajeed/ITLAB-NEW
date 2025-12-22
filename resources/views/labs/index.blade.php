@extends('layouts.app')

@section('title', $track->title . ' - Labs')
@section('body-class', 'page-labs')

@section('content')
<div class="container">
    <h1>{{ $track->title }} - Labs</h1>
    <p><a href="{{ route('tracks.show', $track) }}">← Back to {{ $track->title }}</a></p>

    @if($labs->count() > 0)
        <ul style="list-style: none; padding: 0;">
            @foreach($labs as $lab)
                <li style="margin-bottom: 15px; padding: 15px; background: #1e293b; border-radius: 5px;">
                    <a href="{{ route('tracks.labs.show', [$track, $lab]) }}" style="color: #04aa6d; text-decoration: none; font-size: 18px; font-weight: 600;">
                        {{ $lab->title }}
                    </a>
                    @if($lab->scenario)
                        <p style="color: #9ca3af; margin-top: 5px; margin-bottom: 0;">{{ Str::limit($lab->scenario, 100) }}</p>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p style="color: #9ca3af;">No labs available yet.</p>
    @endif
</div>
@endsection

