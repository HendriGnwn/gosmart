<div class="col-md-3">
    <div class="panel panel-default panel-flush">
        <div class="panel-heading">
            Sidebar
        </div>

        <div class="panel-body">
            <ul class="nav" role="tablist">
                <li role="presentation">
                    <a href="{{ url('/admin') }}">
                        Dashboard
                    </a>
                </li>
				<li role="presentation">
                    <a href="{{ url('/admin') }}">
                        Orders
                    </a>
                </li>
				<li role="presentation">
                    <a href="{{ url('/admin') }}">
                        Privates
                    </a>
                </li>
				<li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                        Master Data &nbsp;&nbsp;<span class="caret"></span>
                    </a>
					<ul class="dropdown-menu" role="menu">
						<li role="presentation" ><a href="#">Bank</a></li>
						<li role="presentation" ><a href="#">Payment</a></li>
						<li role="presentation" ><a href="#">Course</a></li>
						<li role="presentation" ><a href="#">Course Level</a></li>
					</ul>
                </li>
				<li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" role="button" aria-expanded="false">
                        User Managements &nbsp;&nbsp;<span class="caret"></span>
                    </a>
					<ul class="dropdown-menu" role="menu">
						<li role="presentation" class="dropdown-header">User Apps</li>
						<li role="presentation" ><a href="#">Students</a></li>
						<li role="presentation" ><a href="#">Teachers</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation" class="dropdown-header">User Admin</li>
						<li role="presentation" ><a href="#">User</a></li>
					</ul>
                </li>
				
            </ul>
        </div>
    </div>
</div>
