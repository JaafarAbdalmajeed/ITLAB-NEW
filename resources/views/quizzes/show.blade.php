@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $quiz->title }}</h1>

    <form method="POST" action="{{ route('tracks.quizzes.results.store', [$track, $quiz]) }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() ?? 1 }}">
        @foreach($quiz->questions as $question)
            <fieldset>
                <legend>{{ $question->question }}</legend>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="a"> {{ $question->option_a }}</label><br>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="b"> {{ $question->option_b }}</label><br>
                <label><input type="radio" name="answers[{{ $question->id }}]" value="c"> {{ $question->option_c }}</label>
            </fieldset>
        @endforeach
        <button type="submit">Submit</button>
    </form>
</div>
@endsection
