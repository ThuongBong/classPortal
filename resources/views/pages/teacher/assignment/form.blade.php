<div class="container-fluid">
    <form role="form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group {{ $errors->first('title') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Title <sup class="text-danger">(*)</sup></label>
                            <div>
                                <input type="text" class="form-control"  placeholder="Title" name="title" value="{{ old('title', isset($assignment) ? $assignment->title : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('title') }}</p></span>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->first('class_id') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Class <sup class="text-danger">(*)</sup></label>
                            <div>
                                <select name="class_id" class="form-control select-class" url="{{ route('get.subject.by.class') }}">
                                    <option value="">Select Class</option>
                                    @foreach($class as $item)
                                        <option
                                                {{ old('class_id', isset($assignment->class_id) ? $assignment->class_id : '') == $item->id || isset($classId) && $classId == $item->id ? 'selected="selected"' : ''}}
                                                value="{{$item->id}}"
                                        >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('subject_id') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('subject_id') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Subjects <sup class="text-danger">(*)</sup></label>
                            <div>
                                <select name="subject_id" class="form-control select-subject">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option
                                                {{old('subject_id', isset($assignment->subject_id) ? $assignment->subject_id : '') == $subject->id ? 'selected="selected"' : ''}}
                                                value="{{$subject->id}}"
                                        >{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('subject_id') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('due_date') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Due date </label>
                            <div>
                                <input type="datetime-local" class="form-control" name="due_date" value="{{ old('due_date', isset($assignment) ? convertDatetimeLocal($assignment->due_date) : '') }}">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('due_date') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('source') ? 'has-error' : '' }} ">
                            <label for="inputEmail3" class="control-label default">Source </label>
                            <div>
                                <input type="file" class="form-control" name="source" value="">
                                <span class="text-danger "><p class="mg-t-5">{{ $errors->first('source') }}</p></span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('description') ? 'has-error' : '' }}">
                            <label for="inputEmail3" class="control-label default">Description <sup class="text-danger">(*)</sup></label>
                            <div>
                                <textarea name="description" style="resize:vertical" id="description" class="form-control" placeholder="">{{ old('description', isset($assignment) ? $assignment->description : '') }}</textarea>
                                <script>
                                    ckeditor(description);
                                </script>
                                <span class="text-danger"><p class="mg-t-5">{{ $errors->first('description') }}</p></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-set">
                            <button type="submit" name="submit" class="btn btn-info">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <button type="reset" name="reset" value="reset" class="btn btn-danger">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </form>
</div>
