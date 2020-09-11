@extends('backend.layout')

@section('content')

<div class="content">

    <div class="content-header p-1">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-6">
                    <h3 class="m-0 text-dark">記事</h3>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.article.index') }}">記事</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('backend.article.list') }}">一覧</a></li>
                        <li class="breadcrumb-item active">新規作成・編集</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <div class="container-fluid">

        @if ($errors->has('message'))
        <div class="alert alert-danger">

            <div>
                <strong>エラーが発生しました。</strong>
            </div>

            {{ $errors->first('message') }}
        </div>
        @endif

        <div class="card">

            {!! Form::open(['route' => ['backend.article.update', $id], 'files' => false, 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('page', request()->old('page', '')) !!}

            <div class="card-body">

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right required">タイトル</label>

                    <div class="col-sm-9 input-group">
                        {!! Form::text('title', request()->old('title'), ['class' => 'form-control'.($errors->has('title')?' is-invalid':''), 'placeholder' => 'タイトル']) !!}

                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right">画像</label>

                    <div class="col-sm-9 input-group">

                        <div class="upload-image" data-name="image" data-url="{{ route('backend.uploadImage.store') }}" data-asset="{{ asset('') }}"  data-load-options='{}' >

                            {!! Form::hidden('image', request()->old('image')) !!}

                            <div class="preview"{{ !request()->old('image')?' style=display:none':'' }}>
                                <img class="thumbnail"{{ request()->old('image')?'src='.asset(request()->old('image')):''}}>
                            </div>


                            <div class="drop clickable">
                                <span class="clickable"><i class="fa fa-arrow-down"></i> ファイルをドロップしてください</span>
                            </div>

                        </div>

                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right">概要・説明</label>

                    <div class="col-sm-9 input-group">

                        {!! Form::textarea('description', request()->old('description'), ['class' => 'form-control', 'rows' => 10, 'placeholder' => '概要・説明']) !!}

                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right required">投稿日</label>

                    <div class="col-sm-9 input-group">

                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar"></i>
                            </span>
                        </div>
                        {!! Form::text('published_at', request()->old('published_at'), ['class' => 'form-control float-right datetimepicker'.($errors->has('published_at')?' is-invalid':''), 'data-toggle' => 'datetimepicker', 'id' => 'published_at', 'data-target' => '#published_at']) !!}

                        <div class="invalid-feedback">
                            {{ $errors->first('published_at') }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-12">
                        {!! Form::button('<i class="far fa-save"></i> 保存', ['type' => 'submit', 'class' => 'btn btn-info']) !!}
                    </div>
                </div>

            </div>

            {!! Form::close() !!}

        </div>

    </div>
</div>

@stop
