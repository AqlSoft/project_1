@extends('layouts.admin')
@section('title') Add New Items @endsection
@section('headerLinks')
    @parent
    <script src="https://cdn.tiny.cloud/1/oo4peickkmvjnpf2uqjr5hx9z9bdq4lkzwirrfilsvj367jp/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('homePage') {{ auth()->user()->company_name }} @endsection
@section('homeLink') Store @endsection
@section('homeLinkActive') Items / Add New Item @endsection
@section('links')
    <button class="btn btn-sm btn-primary">
        <a href="{{ route('items.home') }}">
            <span class="btn-title">Go Back for Items Home</span>
            <i class="fa fa-home text-light"></i>
        </a>
    </button>
@endsection
@section('content')

    <div class="container">

        <div class="row">
            <div class="col col-2"></div>
            <div class="col col-8 border">
                <fieldset>
                    <form id="regForm" action="{{ route('items.store') }}" method="post">
                        @csrf
                        <legend>Add New Item</legend>

                        <!-- One "tab" for each step in the form: -->
                        <div class="tab" style="">
                            <h4 class="mb-4">Basic Info:</h4>
                            <div class="input-group mb-3">
                                <label for="Type" class="input-group-text">Type</label>
                                <select id="itemType" required class="form-control" >
                                    <option>Select Item type</option>
                                    <option value="0">Storable</option>
                                    <option value="1">Service</option>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <label for="ItemCategory" class="input-group-text">Parent Category</label>
                                <select id="ItemCategory" class="form-control" name="parent_cat ">
                                    <option value="">Select Parent Category</option>
                                    @foreach ($cats as $in => $cat)
                                        @if ($cat->level == 3)
                                            <option {{ old('parent_cat ') == $cat->id ? 'selected':'' }} value="{{ $cat->level }}|{{ $cat->id }}">
                                                {{ $cat->_parent != null ? $cat->_parent->e_name . ' - ': '' }} {{ $cat->e_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="input-group-text">
                                    <a href="{{ route('items.cats.add', 0) }}" target="_blank"><i class="fa fa-plus"></i></a>
                                </span>
                            </div>
                            <div class="input-group mb-3">
                                <label for="a_name" class="input-group-text">Item Name</label>
                                <input type="text" name="a_name" id="a_name" class="form-control" placeholder="Arabic Name">
                                <input type="text" name="e_name" id="a_name" class="form-control" placeholder="Latin Name">
                            </div>
                            <div class="input-group mb-3">
                                <label for="model" class="input-group-text">Codes</label>
                                <input type="text" name="model" id="model" class="form-control" placeholder="Item Model">
                                <input type="text" name="code" id="code" class="form-control" placeholder="Item Short Name">
                            </div>
                            <div class="input-group mb-3">
                                <textarea  name="brief" id="myeditorinstance" class="form-control" placeholder="Item Description" style="box-shadow: 0 0 5px 1px #333"></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label for="barcode" class="input-group-text">Bar Code</label>
                                <input  type="text" name="barcode" id="barcode" class="form-control" placeholder="Item Barcode">
                                <label for="barcode" class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </div>


                        </div>

                        <div class="tab">
                            <h4>Contact Info:</h4>

                        </div>
                        <div class="tab">Birthday:
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Launch demo modal
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            ...
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <br><br><br>
                        <div class="tab">Login Info:
                            <p><input placeholder="Username..." oninput="this.className = ''" name="uname"></p>
                            <p><input placeholder="Password..." oninput="this.className = ''" name="pword" type="password"></p>
                        </div>
                        <div class="buttons" style="overflow:auto;">
                            <div style="float:right;">
                                <button class="btn btn-disabled" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button class="btn btn-next" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                <button class="btn btn-submit" type="button" id="submitBtn">Submit</button>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->
                        <div class="steps">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
        <div id="modals">
            <div class="modal fade" id="addNewItemCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        Modal Triggered
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        $('[placeholder]').click(function () {
            $(this).attr('data-text', $(this).attr('placeholder'))
            $(this).attr('placeholder', '')
        }).blur(function () {
            $(this).attr('placeholder', $(this).attr('data-text'))
        });
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {

                document.getElementById("prevBtn").classList.add('btn-disabled');
                document.getElementById("prevBtn").setAttribute('disabled', 'disabled');
                document.getElementById("prevBtn").classList.remove('btn-next');
            } else {
                document.getElementById("prevBtn").classList.remove('btn-disabled');
                document.getElementById("prevBtn").removeAttribute('disabled');
                document.getElementById("prevBtn").classList.add('btn-next');
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").classList.remove('btn-next');
                document.getElementById("nextBtn").classList.add('btn-disabled');
                document.getElementById("submitBtn").classList.remove('btn-disabled');
                document.getElementById("submitBtn").classList.add('btn-submit')
                document.getElementById("submitBtn").setAttribute('type', 'submit')
                document.getElementById("submitBtn").removeAttribute('disabled');
            } else {
                document.getElementById("nextBtn").classList.remove('btn-disabled');
                document.getElementById("nextBtn").classList.add('btn-next');
                document.getElementById("submitBtn").classList.remove('btn-submit')
                document.getElementById("submitBtn").classList.add('btn-disabled');
                document.getElementById("submitBtn").setAttribute('type', 'button')
                document.getElementById("submitBtn").setAttribute('disabled', 'disabled');

            }
            //... and run a function that will display the correct step indicator:

            fixStepIndicator(n)
        }

        function nextPrev(n) {

            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
    <script>
        tinymce.init({
            selector: 'textarea',
            menubar: false,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

    </script>
@endsection
