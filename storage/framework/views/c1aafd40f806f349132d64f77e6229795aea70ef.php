<?php $__env->startSection('title'); ?>
    View Payroll
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main_section'); ?>
  <div class="well">
		<input type="hidden" id="token" value="<?php echo e(csrf_token()); ?>">
    <div class="form-group row">
		<div class="col-lg-4">
			<label for="sel1">Select Payroll to View:</label>
			<select id="payrollSelect" class="form-control">
				<?php if(is_object($payrolls)): ?>
					<?php $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<option value="<?php echo e($payroll->date_paid); ?>"><?php echo e(date('F Y', strtotime($payroll->date_paid))); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
					<option value="<?php echo e($payroll->date_paid); ?>"><?php echo e(date('F Y', strtotime($payrolls->date_paid))); ?></option>
				<?php endif; ?>
			</select>
			<button id="testsubmit">Submit</button>
		</div>
    </div>
	<div id="showPayroll" class="row"></div>
  </div>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('../layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>