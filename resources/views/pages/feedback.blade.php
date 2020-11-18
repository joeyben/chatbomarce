@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow qa">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">{{ __('Feedback') }}</h3>
                        </div>
                        <div class="col1">
                            <b-button class="btn btn-success" data-toggle="modal" data-target="#addfbModal" data-backdrop="false">
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
                    <list-feedback-component ref="feedback-list"></list-feedback-component>
                </div>
            </div>
        </div>
    </div>
    <add-feedback-component></add-feedback-component>
    <edit-feedback-component></edit-feedback-component>
</div>
@endsection
