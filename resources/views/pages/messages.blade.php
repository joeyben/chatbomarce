@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Messages</h3>
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
                                <th scope="col">Whatsappnr</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <th scope="row">
                                        {{ $message->whatsapp }}
                                    </th>
                                    <td>
                                        {{ $message->message }}
                                    </td>
                                    <td>
                                        {{ $message->created_at->diffForHumans() }}
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
