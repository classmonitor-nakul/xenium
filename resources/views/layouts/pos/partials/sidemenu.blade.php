<aside class="main-sidebar"> 
    <!-- sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image text-center"><img src="{{ asset('assets/img/23804676.jpeg') }}" class="img-circle" alt="User Image"> </div>
        <div class="info">
          <p>{{ Auth::user()->name }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
      </div>
      <!-- sidebar menu -->
      <ul class="sidebar-menu" data-widget="tree">
        @if($modules) 
          @foreach ($modules as $module)
          <li class="treeview"> <a href="#"> <i class="fa-light {{ $module->icon }}"></i> <span>{{ $module->module}}</span> <span class="pull-right-container"> <i class="fa-light fa-angle-left pull-right"></i> </span> </a>
            <ul class="treeview-menu">
              @foreach ($submodules as $submodule)
              @if($module->id == $submodule->mod_id)
              <li><a href="{{route($submodule->link)}}"><i class="fa fa-angle-right"></i> {{$submodule->submodule}}</a></li>
              @endif
              @endforeach
            </ul>
          </li>
          @endforeach
        @endif
      </ul>
    </div>
    <!-- /.sidebar --> 
  </aside>