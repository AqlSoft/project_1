@extends('layouts.admin')
@section('title') الإعدادات العامة @endsection
@section('homeLink') الأدوار @endsection
@section('homeLinkActive') إضافة إجراء جديد @endsection
@section('links')
    <button class="btn btn-sm btn-primary"><a href="{{ route('rules.home') }}">
        <span class="btn-title">العودة إلى الرئيسية</span>
        <i class="fa fa-home text-light"></i></a>
    </button>

@endsection
@section('content')
<style>
    
</style>
<div class="container pt-4" style="min-height: 100vh">
    <fieldset class="pt-5">
        <legend>إضافة إجراءات جديدة للدور</legend>
        
        <form action="{{ route('rules.storeActions') }}" method="post">

            @csrf
            <input type="hidden" name="id" id="rule_id" required value="{{ $rule->id }}">
            <div class="input-group mt-3">
                <label for="name" class="input-group-text required">اسم الدور:</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ $rule->name }}">
                
            </div>

            <div class="input-group mt-3">
                <label for="mainMenu" class="input-group-text required"> القائمة الرئيسية: </label>
                <select name="menu" id="MainMenu" class="form-control">
                    <option hidden> اختر القائمة الرئيسية </option>
                    @foreach ($menues as $mi => $menu)
                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endforeach
                </select>

                <label for="subMenu" class="input-group-text required"> القائمة الفرعية: </label>
                <select name="submenu" id="subMenu" class="form-control">
                    <option hidden> اختر القائمة الفرعية </option>
                    
                </select>
            
            
            </div>
            <div id="actions" class="row py-3"></div>
           
            <div style="">
                <br>
                <button id="dismiss_btn" class="btn btn-info" 
                onclick="window.location='{{route('rules.home')}}'" type="button" id="submitBtn">إلغاء</button>
                <button class="btn btn-success" type="submit" id="submitBtn">تسجيل دور جديد</button>
            </div>

            
        </form>
        <div class="alert alert-sm px-3 py-1 alert-secondary float-right d-inline-block text-info mt-3 text-right">( <span style="color: red">*</span> ) تشير إلى حقول مطلوبة.</div>
    </fieldset>

    <input type="hidden" id="gotopermissioncreate" value="{{route('permissions.create', ['subMenu', 'mainMenu'])}}">

</div>
@endsection


@section('script')
<script type="text/javascript">
    $(document).on('change', '#MainMenu', function () {
        console.log($('#MainMenu').val())
        
        var myFormData = new FormData($('#form_id')[0])
        if ($('#MainMenu').val() != null && $('#MainMenu').val() > 0) {
            $.ajax({
                type:       'post',
                url:        "{{route('submenues.getMenuesOf')}}",
                data:    {
                    '_token': "{{csrf_token()}}",
                    'id': $('#MainMenu').val(),
                    'rule_id': $('#MainMenu').val(),
                },
                success: function (response) {

                    $('#subMenu').html('')
                    $('#subMenu').append(`<option hidden> اختر القائمة الفرعية </option>`)
                    for (var smi = 0; smi < response.length; smi++ ) {
                            $('#subMenu').append('<option value="'+response[smi].id+'">'+response[smi].name+'</option>')
                    }
                    
                },
                error: function () {
    
                }
            })
        } else {
            $('#tableQuery > div').css('display', 'none');
        }
    });

    $(document).on('change', '#subMenu', function () {
        console.log($('#subMenu').val())
        
        var myFormData = new FormData($('#form_id')[0])
        if ($('#subMenu').val() != null && $('#subMenu').val() > 0) {
            $.ajax({
                type:       'post',
                url:        "{{route('permissions.getActionsOf')}}",
                data:    {
                    '_token': "{{csrf_token()}}",
                    'id': $('#subMenu').val(),
                    'rule_id': $('#rule_id').val(),
                },

                success: function (response) {


                    var urlGenerated = $('#gotopermissioncreate').val();
                    var mainMenu = $('#subMenu').val();
                    var subMenu = $('#MainMenu').val();

                    var createNewActionUrl = urlGenerated.replace('mainMenu', mainMenu).replace('subMenu', subMenu);

                    $('#actions').html('')
                    for (var pi = 0; pi < response.length; pi++ ) {
                        let inputStatus = response[pi].inActions ? 'checked': '' 
                        $('#actions').append(
                            `<div class="input-group mb-3 col col-lg-4 col-sm-12 col-4">
                                <label class="input-group-text"> <input name="action[]" `+inputStatus+` type="checkbox" value="`+response[pi].id+`" id="chechBoxInput_`+response[pi].id+`"></label>
                                <label class="form-control text-right" style="font: normal 14px/1.5 Cairo" for="chechBoxInput_`+response[pi].id+`">`+
                                    response[pi].name
                                +`</label>
                            </div>`
                        )
                    } 
                    $('#actions').append(
                        `<button class="btn btn-outline-primary btn-sm btn-block"><a href="`+ createNewActionUrl +`">إضافة إجراءات جديدة للقائمة</a></button>`
                    )
                },

                error: function () {}
            })
        } else {
            $('#tableQuery > div').css('display', 'none');
        }
    });
    // `+response[pi].selected ? 'checked': '' +`
    
</script>
@endsection
