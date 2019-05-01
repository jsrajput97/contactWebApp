@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')
    <section class="posts">
        <div class="post">
            <div class="change_password">
                <div class="modal fade" tabindex="-1" role="dialog" id="change_password">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Change Password</h4>
                            </div>
                            <form action="{{ route('change.password') }}" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="currentpassword">Current Password</label>
                                        <input class="form-control" type="password" name="currentpassword" id="currentpassword" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input class="form-control" type="password" name="new_password" id="new_password" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="new_confirm_password">Confirm New Password</label>
                                        <input class="form-control" type="password" name="new_confirm_password" id="new_confirm_password" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>

            <div class="import_contacts">
                <div class="modal fade" tabindex="-1" role="dialog" id="import_contacts">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Import Contacts</h4>
                            </div>
                            <form action="{{ route('import.contacts') }}" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="importcontacts">Select Contacts(only .vcf)</label>
                                        <input type="file" name="importcontacts" class="form-control" id="importcontacts">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import Contacts</button>
                                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>

        </div>
        <div class="err hidden">
            @include('includes.errorMessage')
        </div>
    </section>
    <section class="row new-post">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Your Account</h3></header>
            <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" id="first_name">
                </div>
                <div class="form-group">
                    <label for="image">Image (only .jpg)</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Save Account</button>
                <input type="hidden" value="{{ Session::token() }}" name="_token">
            </form>
        </div>
    </section>
    @if (Storage::disk('local')->has('public/' . $user->first_name . '-' . $user->id . '.jpg'))
        <section class="row new-post">
            <div class="col-md-6 col-md-offset-3" style="margin-top: 20px; width: 50%">
                <img style="max-width: 300px; max-height: 300px; margin-left: auto; margin-right: auto;" src="{{ url('userimage', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="" class="img-responsive">
            </div>
        </section>
    @endif
@endsection