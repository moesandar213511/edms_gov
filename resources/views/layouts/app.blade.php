<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('backend/assets/img/myanmar.png')}}">
  <link rel="icon" type="image/png" href="{{asset('backend/assets/img/myanmar.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    @yield('title')
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="{{asset('backend/assets/css/material-dashboard.css?v=2.1.1')}}" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{asset('backend/assets/demo/demo.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href='https://mmwebfonts.comquas.com/fonts/?font=pyidaungsu' />
  <link rel="stylesheet" href="{{asset('backend/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  @yield('css')
</head>

<body>
  <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="{{asset('backend/assets/img/sidebar-1.jpg')}}">
      <div class="logo">
        <a href="{{url('/')}}" class="simple-text logo-normal">
          <img src="{{asset('backend/assets/img/myanmar.png')}}" alt="" class="img-fluid" width="100px" style="margin-bottom: -20px;margin-top: -20px;">
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav department_show">
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse ">
            <ul class="navbar-nav text-center" style=" line-height: 20pt;font-size: 15px;">
              @if(Auth::check())
                <?php $type=Auth::user()->type; ?>
                @if($type == "admin")
                  <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('admin/create/depart') ? 'text-primary' : ''}}" href="{{url('admin/create/depart')}}">
                    ဌာန
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('admin/create/sub-depart') ? 'text-primary' : ''}}" href="{{url('admin/create/sub-depart')}}">
                    ဌာနခွဲအသစ်ဖွင့်ရန်
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('admin/sub-depart/data') ? 'text-primary' : ''}}" href="{{url('admin/sub-depart/data')}}">
                    ဌာနခွဲစာရင်းကြည့်ရန်
                  </a>
                </li>
                 @elseif($type == "sub_depart_admin")
                 <li class="nav-item">
                  <a class="nav-link h2 {{Request::is('sub_depart/simple/income-letter') ? 'text-primary' : ''}}" href="{{url('sub_depart/simple/income-letter')}}">
                    ဝင်စာပေါင်း
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('sub_depart/simple/outcome-letter') ? 'text-primary' : ''}}" href="{{url('sub_depart/simple/outcome-letter')}}">
                    ထွက်စာပေါင်း
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('sub_depart/important/income-letter') ? 'text-primary' : ''}}" href="{{url('sub_depart/important/income-letter')}}">
                    အရေးကြီးဝင်စာပေါင်း
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('sub_depart/important/outcome-letter') ? 'text-primary' : ''}}" href="{{url('sub_depart/important/outcome-letter')}}">
                    အရေးကြီးထွက်စာပေါင်း
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('sub_depart/profile/setting') ? 'text-primary' : ''}}" href="{{url('sub_depart/profile/setting')}}">
                      ကိုယ်ရေးအချက်အလက်ပြင်ရန်
                  </a>
                </li>
                @elseif($type == "sub_depart_clerk")
                <li class="nav-item">
                  <a class="nav-link h2" href="winsar.html">
                    ဝင်စာပေါင်း
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link h2" href="htutsar.html">
                    ထွက်စာပေါင်း
                  </a>
                </li>
              @endif
              <li class="nav-item dropdown">
                  <a class="nav-link h2 {{Request::is('admin/create/adjure/letter') || Request::is('adjure/letter') ? 'text-primary' : ''}}" href="{{ Auth::user()->type == 'admin' ? url('admin/create/adjure/letter') : url('adjure/letter')}}">
                    အမိန့်နှင့်ညွှန်ကြားချက်
                  </a>
                </li>
              <li class="nav-item dropdown">
                <a class="nav-link h2" href="{{url('logout')}}">
                  ထွက်ရန်
                </a>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </nav>

      <!-- End Navbar -->
      
      @yield('content')
     
    </div>
  </div>
  <!-- The Modal -->
   <div class="modal" id="myModalhtut">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">ထွက်စာအမျိုးအစား</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
            <h1>
              <a href="register.html" class="btn btn-primary h2">ရိုးရိုးထွက်စာ</a>
              <a href="register2.html" class="btn btn-primary h2">အရေးကြီးထွက်စာ</a>
            </h1>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>


    <!-- The Modal -->
   <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">ဌာနခွဲ</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
              <b>ဌာနချုပ်အမည် ။&nbsp;&nbsp;&nbsp;&nbsp;။ </b>၀န်ကြီးဌာန <br>
              <b>ဌာနချုပ်ဖုန်း ။&nbsp;&nbsp;&nbsp;&nbsp;။ </b>၀၉ ၇၃၂၅၆၆၀၄ <br>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>
  <!--   Core JS Files   -->
  <script src="{{asset('backend/assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('backend/assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('backend/assets/js/core/bootstrap-material-design.min.js')}}"></script>
  <script src="{{asset('backend/assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!-- Plugin for the momentJs  -->
  <script src="{{asset('backend/assets/js/plugins/moment.min.js')}}"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="{{asset('backend/assets/js/plugins/sweetalert2.js')}}"></script>
  <!-- Forms Validations Plugin -->
  <script src="{{asset('backend/assets/js/plugins/jquery.validate.min.js')}}"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="{{asset('backend/assets/js/plugins/jquery.bootstrap-wizard.js')}}"></script>
  <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="{{asset('backend/assets/js/plugins/bootstrap-selectpicker.js')}}"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="{{asset('backend/assets/js/plugins/bootstrap-datetimepicker.min.js')}}"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="{{asset('backend/assets/js/plugins/jquery.dataTables.min.js')}}"></script>
  <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="{{asset('backend/assets/js/plugins/bootstrap-tagsinput.js')}}"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="{{asset('backend/assets/js/plugins/jasny-bootstrap.min.js')}}"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="{{asset('backend/assets/js/plugins/fullcalendar.min.js')}}"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="{{asset('backend/assets/js/plugins/jquery-jvectormap.js')}}"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="{{asset('backend/assets/js/plugins/nouislider.min.js')}}"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="{{asset('backend/assets/js/plugins/arrive.min.js')}}"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="{{asset('backend/assets/js/plugins/chartist.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('backend/assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('backend/assets/js/material-dashboard.js?v=2.1.1')}}" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{asset('backend/assets/demo/demo.js')}}"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    // $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
      for (let i = 1; i <= 10; i++) {
        $('.d_down_item'+i+'').hide(100); 
      }
      $(".d_down1").click(()=>{
        $('.d_down_item1').toggle(100);
      });
      $(".d_down2").click(()=>{
        $('.d_down_item2').toggle(100);
      });
      $(".d_down3").click(()=>{
        $('.d_down_item3').toggle(100);
      });
      $(".d_down4").click(()=>{
        $('.d_down_item4').toggle(100);
      });
      $(".d_down5").click(()=>{
        $('.d_down_item5').toggle(100);
      });
    // });
  </script>
  <script src="{{asset('js/toastr.min.js')}}"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script>
    function removeShowEntryOnDataTable(datatable){
      $("#"+datatable).DataTable({
          "bInfo" : false,
          "lengthChange": false
      });
    }
  </script>
   <script>
      var loadData=function(){
        $(".department_show").empty();
        let url="{{url('department/show')}}";
        $.ajax({
          url : url,
          type : "get"
        }).done(function(response){
          response.map(function(data,index){
          $(".department_show").append(`
            <li>
              <a class="nav-link dropdown-toggle" style="font-size: 16px;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ${data['depart_name']}
              </a> 
              <div class="dropdown-menu sub_depart_${data['id']}">`);
                data['sub_depart_data'].map(function(sub_data,index){
                  $(".sub_depart_"+data['id']).append(`<p class="text-center rounded-0">${sub_data['name']}</p>`);
                });
          $('.department_show').append(`</div>
            </li>
          `);
          });

        }).fail(function(error){
          console.log(error);
        });
      }
      loadData();
  </script>
  @yield('js')
</body>
</html>
