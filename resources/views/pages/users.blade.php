@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('texte.pages.user.header') }}</h3>
                            </div>
                            <!--<div class="col text-right">
                              <a href="#!" class="btn btn-sm btn-primary">See all</a>
                            </div>-->
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Whatsapp</th>
                                <th scope="col">Letzte Nachricht</th>
                                <th scope="col">Datenschutz</th>
                                <th scope="col">Erstellt am</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">
                                        <a href="{{ route('wuser', ['id' => $user->id]) }}">{{ $user->whatsapp }}</a>
                                    </th>
                                    <td>
                                        {{ $user->last_message->diffForHumans() }}
                                    </td>
                                    <td>
                                        {{ $user->privacy }}
                                    </td>
                                    <td>
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

