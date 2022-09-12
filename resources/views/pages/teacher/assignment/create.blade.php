@extends('layouts.app')
@section('title', 'Assignments')
@section('page-header', 'Assignments')
@section('content')
    <div class="col-xs-12 col-md-12">
        @include('pages.teacher.session-data')

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    Add Assignments
                </h4>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-md-12">
                    @include('pages.teacher.assignment.form')
                </div>
            </div>
        </div>
    </div>
@endsection