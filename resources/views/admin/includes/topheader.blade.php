{{-- 
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist" style="border: 0">
      <button class="nav-link mr-5 active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
           الرئيسية 
      </button>
      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"> 
           التشغيل 
      </button>
      <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
           المبيعات 
      </button>
      <button class="nav-link" id="nav-purchases-tab" data-bs-toggle="tab" data-bs-target="#nav-purchases" type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">
          المشتريات 
      </button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent" style="">
  
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
        <div class="nav-items mr-5">
          <div class="nav-item">
            <div class="nav-link"><i class="fa fa-home"></i><a href="#">الصفحة الرئيسية</a></div>
            <div class="nav-link"><i class="fa fa-home"></i><a href="#">الصفحة الرئيسية</a></div>
            <div class="nav-link"><i class="fa fa-home"></i><a href="#">الصفحة الرئيسية</a></div>
          </div>
          <div class="nav-item">
            <div class="nav-link"><i class="fa fa-home"></i><a href="#">الصفحة الرئيسية</a></div>
            <div class="nav-link"><i class="fa fa-home"></i><a href="#">الصفحة الرئيسية</a></div>
            <div class="nav-link"><i class="fa fa-home"></i><a href="#">الصفحة الرئيسية</a></div>
          </div>
          
          <div class="nav-item-footer">
            الضـــــــــــــــــبط
          </div>
        </div>

    </div>
    <div class="tab-pane fade show " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="1"><div class="container">operation</div></div>
    <div class="tab-pane fade show " id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="1"><div class="container">Sales</div></div>
    <div class="tab-pane fade show " id="nav-purchases" role="tabpanel" aria-labelledby="nav-purchases-tab" tabindex="1"><div class="container">purchases</div></div>

</div>

<script>
  $(document).ready(function(){
    $('button.nav-link').on('click', function () {
      $('button.nav-link').removeClass('active')
      $(this).addClass('active')
      $('.tab-content .container .tab-pane').removeClass('active')
      $($(this).attr('data-bs-target')).addClass('active')
    }) 
  })
</script> --}}
