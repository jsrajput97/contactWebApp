@extends('layouts.master')
@section('title')
    Login
@endsection
<header>
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">

</header>
@section('content')
    <div style="right: -1px; float: right; margin-right: -15px; margin-top: 5px;" id="gridlist_div">
        @php
        $icon = "fa fa-th";
        $icontext = "Grid";
        if(isset($_COOKIE["tableData"]) && $_COOKIE["tableData"] === "table_data")
        {
            $icon = "fa fa-list";
            $icontext = "List";

        }
        @endphp
        <a id="gridlist_a" style="font-size:24px;text-decoration-line: none;"><span style="color: black; font-size: 18px; margin-right: 5px; float: left;" id="iconText">{{ $icontext }}</span><i class="{{ $icon }}" id="grid_list"></i></a>
    </div>
    <div class="posts">
        <div class="post">
            <div class="create_contact">
                <div class="modal fade addcontact_modal" tabindex="-1" role="dialog" id="addContact">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Add new Contact</h4>
                            </div>
                            <form action="{{ route('contact.create') }}" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="number">Number</label>
                                        <input class="form-control" type="text" name="number" id="number" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" >Save changes</button>
                                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>

            <div class="update_contact">
                <div class="modal fade" tabindex="-1" role="dialog" id="updateContact">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Edit Contact</h4>
                            </div>
                            <form action="#" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control" type="text" name="name" id="uname" value=null required>
                                    </div>
                                    <div class="form-group">
                                        <label for="number">Number</label>
                                        <input class="form-control" type="text" name="number" id="unumber" value="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="updateC">Save changes</button>
                                    <input type="hidden" value="{{ Session::token() }}" name="_token">
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>

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

        <div class="mycontact" style="margin-top: 40px;" id="displaycontact">
            @if(count($contacts)>0)
                <div>
                    <div class="abcd" ><b>Contacts</b></div><br/>
                    @php
                        if (!isset($_COOKIE["cnames"]))
                        {
                          setcookie('cnames',"");
                          $_COOKIE['cnames'] = "";
                        }

                        if (!isset($_COOKIE["tableData"]) || $_COOKIE["tableData"] === "")
                        {
                            setcookie('tableData',"table_data1");
                            $_COOKIE['tableData'] = "table_data1";
                        }

                        $sname = $_COOKIE["cnames"];
                        $count = 0;
                        $tableData = $_COOKIE["tableData"];

                    @endphp
                    <div class="mobile">
                        @foreach($contacts as $contact)
                            @if($sname === null || $sname === "" || strlen($sname) === 0)
                                <div id="{{ $tableData }}" class="set_table_data">
                                    <div class="card">
                                        <div class="contains" data-contactid="{{ $contact->id }}">
                                            <div class="edtdlt">
                                                <h4 style="float: left;"><b>{{ $contact->name }}</b></h4>
                                            </div>
                                            <p style="float: left;">{{ $contact->number }}</p><p id="pmargin"><a href="#" onclick="editContacts(event)" class="edit">Edit</a>  <a href="{{ route('contact.delete',['contact_id' => $contact->id]) }}">Delete</a> </p>
                                        </div>
                                    </div>
                                </div>
                            @elseif(substr(strtolower($contact->name), 0, strlen($sname)) === strtolower($sname))
                                <div id="{{ $tableData }}" class="set_table_data1">
                                    <div class="card">
                                        @php
                                            $count = $count+1;
                                            if(ctype_upper($contact->name{0}))
                                            {
                                                $sname1 = strtolower($sname);
                                                $sname1 = ucfirst($sname1);
                                            }
                                            else
                                            {
                                                $sname1 = strtolower($sname);
                                             }
                                        @endphp
                                        <div class="contains" data-contactid="{{ $contact->id }}">
                                            <div class="edtdlt">
                                                <h4 style="float: left;"><b><?=str_replace_first($sname1,"<span style='color:blue;'>$sname1</span>",$contact->name)?></b></h4>
                                            </div>
                                            <p style="float: left;">{{ $contact->number }}</p><p id="pmargin"><a href="#" onclick="editContacts(event)" class="edit">Edit</a>  <a href="{{ route('contact.delete',['contact_id' => $contact->id]) }}">Delete</a> </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($count === 0 && $sname !== "")
                        <h1>Contact not found using name: "{{ $sname }}"</h1>
                        <h3>Please try a different name</h3>
                    @endif

                </div>
            @else
                <h1>Contacts are empty</h1>
                <h3>Add new contact</h3>
            @endif
        </div>
    </div>
    <script>
        var token = '{{Session::token()}}';
        var url = '{{ route('update') }}';
        window.onbeforeunload = function() {
            document.cookie = "cnames = " + "";
            document.cookie = "tableData = " + "";
        };
    </script>
    <script src="{{ URL::to('src/js/app.js') }}"></script>

@endsection