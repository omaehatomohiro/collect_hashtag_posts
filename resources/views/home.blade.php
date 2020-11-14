@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <form action="{{ url('/hash/add')}}" method="POST">
                            @csrf
                            <input type="text" name="hash_name" >
                            <button class="btn">ハッシュ登録</button>
                        </form>
                    </div>
                    <div class="mt-2">
                        <form>
                            <div class="container">
                                <div class="row">
                                @forelse ($hashs as $hash)
                                    <div class="col-xs-2 mr-1">
                                        <input type="checkbox" name="select_hash">
                                        {{ $hash->name }}
                                    </div>
                                @empty
                                    <li>ユーザーなし</li>
                                @endforelse
                                </div>
                            </div>
                            <button class="btn">検索</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
