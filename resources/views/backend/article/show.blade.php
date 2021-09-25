@extends('backend.layout')

@section('content')

<div class="content">

    <div class="content-header p-2">

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
                        <li class="breadcrumb-item active">詳細</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">

                <a href="{{ route('backend.article.list') }}?page={{ request()->get('page') }}" class="btn btn-info"><i class="fas fa-list"></i> 一覧</a>

                @can('edit article')
                <a href="{{ route('backend.article.edit', ['id' => $article->id]) }}?page={{ request()->get('page') }}" class="btn btn-info"><i class="fas fa-edit"></i> 編集</a>
                <a href="{{ route('backend.article.destroy', ['id' => $article->id]) }}?page={{ request()->get('page') }}" class="btn btn-danger" data-toggle="delete-confirm"><i class="far fa-trash-alt"></i> 削除</a>
                @endcan

            </div>

            <div class="card-body">

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right">タイトル</label>

                    <div class="col-sm-9 form-control-plaintext">
                        {{ $article->title }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right">画像</label>

                    <div class="col-sm-9 form-control-plaintext">
                        @if ($article->image)
                        <div>
                        <img src="{{ asset($article->image) }}"  class="img-thumbnail imageOverlay" style="max-width: 300px">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right">概要・説明</label>

                    <div class="col-sm-9 form-control-plaintext">
                        {!! nl2br(e($article->description)) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label text-md-right">公開日</label>

                    <div class="col-sm-9 form-control-plaintext">
                        {{ $article->published_at->format('Y年n月j日 H：i') }}
                    </div>
                </div>

            </div>

            <div class="card-footer">

                <a href="{{ route('backend.article.list') }}?page={{ request()->get('page') }}" class="btn btn-info"><i class="fas fa-list"></i> 一覧</a>

                @can('edit article')
                <a href="{{ route('backend.article.edit', ['id' => $article->id]) }}?page={{ request()->get('page') }}" class="btn btn-info"><i class="fas fa-edit"></i> 編集</a>
                <a href="{{ route('backend.article.destroy', ['id' => $article->id]) }}?page={{ request()->get('page') }}" class="btn btn-danger" data-toggle="delete-confirm"><i class="far fa-trash-alt"></i> 削除</a>
                @endcan

            </div>

        </div>

   </div>
</div>

@stop
