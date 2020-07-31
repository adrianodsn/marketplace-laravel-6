@extends('layouts.app')

@section('content')
    <h3 class="mb-5">Notificações</h3>
    @if ($unreadNotifications->count())
        <a class="btn btn-success mb-3" href="{{route('admin.notifications.read.all')}}">Marcar tudo como lido</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Notificação</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unreadNotifications as $n)
                <tr>
                    <td>
                        <b>{{isset($n->data['title']) ? $n->data['title'] : ''}}</b>
                        <div>{{$n->data['message']}}</div>
                    </td>
                    {{-- <td>{{$n->created_at->format('d/m/Y H:i:s')}}</td> --}}
                    <td>{{$n->created_at->diffForHumans()}}</td>
                    <td class="text-right">
                        <a class="btn btn-primary btn-sm" href="{{route('admin.notifications.read', ['notification' => $n->id])}}">Marcar como lida</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$unreadNotifications->links()}}
    @else
        <div class="alert alert-success">
            Você não possui notificações :)
        </div>
    @endif
@endsection