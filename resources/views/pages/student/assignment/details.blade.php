@extends('layouts.app')
@section('title', $assignment->title)
@section('page-header', $assignment->title)
@section('content')
    <div class="col-xs-12 col-md-12">
        @include('pages.teacher.session-data')

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    {{ $assignment->title }}
                </h4>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-md-12">
                    <h3>Description</h3>
                    {!! $assignment->description !!}

                    @if (!empty($assignment->due_date))
                    <p>Due date : {{ formatTime($assignment->due_date) }}</p>
                    @endif

                    @if (!empty($assignment->source))
                        <p>Source : <a href="{!! asset('uploads/assignments/' . $assignment->source) !!}" target="_blank">{{ $assignment->source }}</a></p>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Answer
                </h4>
            </div>
            <div class="panel-body">
                @if (
                (!empty($assignment->due_date) && checkTime($assignment->due_date) < 0 || $result && !empty($result->mark))
                || (empty($assignment->due_date) && $result && !empty($result->mark))
                )
                    <div class="col-xs-12 col-md-12">
                        <h3>Description</h3>
                        {!! $result->description !!}
                        @if (!empty($result->source))
                            <p>Source : <a href="{!! asset('uploads/assignments/' . $result->source) !!}" target="_blank">{{ $result->source }}</a></p>
                        @endif
                        @if (!empty($result->mark))
                            <p>Mark : {{ $result->mark }}</p>
                        @endif
                    </div>
                @else
                    <div class="col-xs-12 col-md-12">
                        @include('pages.student.assignment.form')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection