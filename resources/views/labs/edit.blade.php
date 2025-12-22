@extends('layouts.app')

@section('title', 'Edit Lab - ' . $lab->title)
@section('body-class', 'page-lab-edit')

@section('content')
<div class="container">
    <h1>Edit Lab: {{ $lab->title }}</h1>
    <p><a href="{{ route('tracks.labs.show', [$track, $lab]) }}">← Back to Lab</a></p>

    <form method="POST" action="{{ route('tracks.labs.update', [$track, $lab]) }}" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $lab->title) }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="scenario" style="display: block; margin-bottom: 5px; font-weight: 600;">Scenario</label>
            <textarea id="scenario" name="scenario" class="form-control" rows="10">{{ old('scenario', $lab->scenario) }}</textarea>
            @error('scenario')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
            Update Lab
        </button>
    </form>
</div>
@endsection

