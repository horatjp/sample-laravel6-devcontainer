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
                        <li class="breadcrumb-item active">一覧</li>
                    </ol>
                </div>

            </div>

        </div>
    </div>

    <div class="container-fluid">

        <div class="card">

            {!! Form::open(['route' => ['backend.article.list'], 'class' => 'form-horizontal']) !!}

            <div class="card-body">

                <div class="row">

                    <div class="col-sm-5">

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label text-md-right">タイトル</label>

                            <div class="col-sm-8">
                                {!! Form::text('search[title]', empty(request()->get('search')['title'])?'':request()->get('search')['title'], ['class' => 'form-control']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-5">

                        <div class="form-group row">
                            <label for="" class="col-sm-4 col-form-label text-md-right">サンプル</label>

                            <div class="col-sm-8">
                                {!! Form::select('sample', ['' => '　', '1' => 'sample', '2' => 'test'], null, ['class' => 'form-control select2']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 text-right">
                        {!! Form::button('<i class="fas fa-search"></i> 検索', ['type' => 'submit', 'name' => 'search[submit]', 'class' => 'btn btn-info']) !!}
                    </div>

                </div>
            </div>

            {!! Form::close() !!}
        </div>


        <div class="card">

            <div class="card-header">

                @can('edit article')
                <a href="{{ route('backend.article.edit') }}" class="btn btn-info"><i class="fas fa-plus"></i> 新規作成</a>
                @endcan

            </div>

            <div class="card-body p-1">

                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap">
                        <thead class="bg-dark">
                            <tr>
                                <th style="width:10px;">ID</th>
                                <th style="width:300px">タイトル</th>
                                <th>公開日</th>
                                <th style="width:200px">操作</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($articles as $article)
                            <tr class="{{ $article->active?'':'table-secondary' }}">

                                <td>{{ $article->id }}</td>
                                <td style="white-space:normal;min-width:400px;">
                                    {{ $article->title }}
                                </td>
                                <td>
                                    {{ $article->published_at->format('Y年n月j日 H：i') }}
                                </td>

                                <td class="text-right">

                                    <a href="{{ route('backend.article.changeActive', ['id' =>$article->id]) }}?page={{ $articles->currentPage() }}" class="badge badge-info p-1">{{ $article->active?'表示中':'非表示' }}</a>

                                    <a href="{{ route('backend.article.show', ['id' =>$article->id]) }}?page={{ $articles->currentPage() }}" class="btn btn-info btn-sm"><i class="far fa-file-alt"></i></a>

                                    @can('edit article')
                                    <a href="{{ route('backend.article.edit', ['id' =>$article->id]) }}?page={{ $articles->currentPage() }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('backend.article.destroy', ['id' =>$article->id]) }}?page={{ $articles->currentPage() }}" class="btn btn-danger btn-sm" data-toggle="delete-confirm"><i class="far fa-trash-alt"></i></a>
                                    @endcan

                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="px-3">

                    <div class="float-left">
                        全{{ $articles->total() }}件
                    </div>


                    <div class="float-right">

                        {!! $articles->render() !!}

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>



@stop
