<li class="m-t-20 {{ (Request::is('admin/order*')) ? 'active' : '' }}">
    <a href="{{url('admin/order')}}">Orders</a>
    <span class="{{ (Request::is('admin/order*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-cart-plus"></i></span>
</li>

<li class="{{ (Request::is('admin/private*')) ? 'active' : '' }}">
    <a href="{{url('admin/private')}}">Privates</a>
    <span class="{{ (Request::is('admin/private*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-bookmark"></i></span>
</li>

<li class="
	{{ (Request::is('admin/bank*') || 
				Request::is('admin/payment*') || 
				Request::is('admin/course*') || 
				Request::is('admin/course-level*')
		) ? 'open active' : ''}}">
    <a href="javascript:;"><span class="title">Master Data</span> 
        <span class="arrow {{ (Request::is('admin/bank*') || 
				Request::is('admin/payment*') || 
				Request::is('admin/course*') || 
				Request::is('admin/course-level*')
		) ? 'open active' : ''}}"></span>
    </a> 
    <span class="{{ (Request::is('admin/bank*') || 
				Request::is('admin/payment*') || 
				Request::is('admin/course*') || 
				Request::is('admin/course-level*')
		) ? 'bg-success' : ''}} icon-thumbnail">
        <i class="fa fa-briefcase"></i>
    </span>

    <ul class="sub-menu">
        <li class="{{ (Request::is('admin/bank*')) ? 'active' : '' }}">
            <a href="{{url('admin/bank')}}">Bank</a> 
            <span class="{{ (Request::is('admin/bank*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-money"></i></span>
        </li>
        <li class="{{ (Request::is('admin/payment*')) ? 'active' : '' }}">
            <a href="{{url('admin/payment')}}">Payment</a> 
            <span class="{{ (Request::is('admin/payment*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-money"></i></span>
        </li>
        <li class="{{ (Request::is('admin/course*')) ? 'active' : '' }}">
            <a href="{{url('admin/course')}}">Course</a> 
            <span class="{{ (Request::is('admin/course*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-book"></i></span>
        </li>
        <li class="{{ (Request::is('admin/course-level*')) ? 'active' : '' }}">
            <a href="{{url('admin/course-level')}}">Course Level</a> 
            <span class="{{ (Request::is('admin/course-level*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-book"></i></span>
        </li>
    </ul>
</li>
<li class="
	{{ (Request::is('admin/student*') || 
				Request::is('admin/teacher*') || 
				Request::is('admin/user*')
		) ? 'open active' : ''}}">
    <a href="javascript:;"><span class="title">User Managements</span> 
        <span class="arrow {{ (Request::is('admin/student*') || 
				Request::is('admin/teacher*') || 
				Request::is('admin/user*')
		) ? 'open active' : ''}}"></span>
    </a> 
    <span class="{{ (Request::is('admin/student*') || 
				Request::is('admin/teacher*') || 
				Request::is('admin/user*')
		) ? 'bg-success' : ''}} icon-thumbnail">
        <i class="fa fa-users"></i>
    </span>

    <ul class="sub-menu">
        <li class="{{ (Request::is('admin/student*')) ? 'active' : '' }}">
            <a href="{{url('admin/student')}}">Students</a> 
            <span class="{{ (Request::is('admin/student*')) ? 'bg-success' : '' }} icon-thumbnail">ST</span>
        </li>
        <li class="{{ (Request::is('admin/teacher*')) ? 'active' : '' }}">
            <a href="{{url('admin/teacher')}}">Teachers</a> 
            <span class="{{ (Request::is('admin/teacher*')) ? 'bg-success' : '' }} icon-thumbnail">TE</span>
        </li>
        <li class="{{ (Request::is('admin/user*')) ? 'active' : '' }}">
            <a href="{{url('admin/user')}}">User</a> 
            <span class="{{ (Request::is('admin/user*')) ? 'bg-success' : '' }} icon-thumbnail"><i class="fa fa-users"></i></span>
        </li>
    </ul>
</li>