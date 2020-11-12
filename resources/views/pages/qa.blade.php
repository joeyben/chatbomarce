@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow qa">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">{{ __('texte.pages.qa.header') }}</h3>
                            </div>
                            <div class="col1">
                                <b-button class="btn btn-success" data-toggle="modal" data-target="#addqaModal" data-backdrop="false">
                                    Hinzufügen
                                </b-button>
                            </div>

                            <!--<div class="col text-right">
                              <a href="#!" class="btn btn-sm btn-primary">See all</a>
                            </div>-->
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <list-component ref="list"></list-component>
                    </div>
                </div>
            </div>
        </div>
        <add-component></add-component>
        <edit-component></edit-component>
    </div>
@endsection
