<nav class="navbar navbar-inverse navbar-fixed-top" style="background: #364156; border: none; z-index: 999">
  <div class="container">
  	<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="collapse navbar-collapse collapse-right">
    	<div id="navbar_padding">
		    <ul class="nav navbar-nav">
		      <li><a href="/">Home</a></li>
		      <li><a href="/payroll">My Payroll</a></li>
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
		      <li><a id="messageModalTrigger" data-toggle="tooltip" data-placement="bottom" title="Messages"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span></a></li>
		      <li class="dropdown">
		        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo e(Auth::user()->name); ?> <span class="caret"></span></a>
		        <ul class="dropdown-menu">
		          <?php if(Auth::user()->role == 'admin'): ?>
		            <li><a href="admin_panel"><span class="glyphicon glyphicon-briefcase"></span> Admin Panel</a></li>
					    <?php endif; ?>
		            <li><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
		                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
		                    <?php echo e(csrf_field()); ?>

		                </form>
		            </li>
		        </ul>
		      </li>
		    </ul>
		</div>
	</div>
  </div>
</nav>

<!-- message modal -->
<div id="messageModal">
	<ul class="nav nav-pills nav-justified">
		<li class="active"><a data-toggle="pill" href="#inbox">Inbox</a></li>
		<li><a data-toggle="pill" href="#ticket">File a Ticket</a></li>
	</ul>

	<div class="tab-content">
		<div id="inbox" class="tab-pane fade in active">
			<div id="inboxArea"></div>
		</div>
		<div id="ticket" class="tab-pane fade">
			<h3>File a ticket</h3>
			<input type="hidden" id="msg_token" value="<?php echo e(csrf_token()); ?>">
			<div class="form-group">
				<input type="text" class="form-control" id="subject" placeholder="Subject" name="subject" required>
			</div>
			<div class="form-group">
				<textarea class="form-control" rows="5" id="message" placeholder="Message" name="message" required></textarea>
			</div>
			<button id="sendTicket" class="btn btn-primary" style="width: 100%"><b>Send</b></button>
		</div>
	</div>
</div>


<div id="errTicketFail"></div>


<div id="succTicketSent"></div>


<div id="errMsgDel"></div>


<div id="succMsgDel"></div>