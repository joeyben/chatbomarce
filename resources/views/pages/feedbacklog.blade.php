@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('texte.pages.usersfeedback.header') }}</h3>
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
                                <th scope="col">{{ __('texte.pages.usersfeedback.question') }}</th>
                                <th scope="col">{{ __('texte.pages.usersfeedback.user') }}</th>
                                <th scope="col">{{ __('texte.pages.usersfeedback.rating') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($usersFeedback as $userfeedback)
                                <tr>
                                    <th scope="row">
                                        {{ $userfeedback->feedback->question }}
                                    </th>
                                    <td>
                                        {{ $userfeedback->user->whatsapp }}
                                    </td>
                                    <td>
                                        {{ $userfeedback->rating }}
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
