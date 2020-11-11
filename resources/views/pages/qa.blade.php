@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow qa">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Fragen und Antworten</h3>
                            </div>
                            <div class="col1">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#questionAnswerModal">
                                   Hinzufügen
                                </button>
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
                                <th scope="col">Fragen</th>
                                <th scope="col">Antworten</th>
                                <th scope="col">Aktionen</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($textes as $text)
                                <tr>
                                    <td scope="row">
                                        {{ $text->questions }}
                                    </td>
                                    <td>
                                        {{ $text->answers }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#questionAnswerModal">
                                            Editieren
                                        </button>

                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#questionAnswerModal">
                                            Löschen
                                        </button>
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

    @include('pages.modals.add-qa')
    @include('pages.modals.edit-qa')
@endsection
