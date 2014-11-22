<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
?>
			</div>

			<div class="col-lg-3">
				<?php include_once ('right.php') ?>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="container">
			<div class="pull-left"><?= show_online() ?></div>
			<div class="pull-right"><?= show_counter() ?></div>
				<?= perfomance() ?>
		</div>
	</div>

	<?= include_javascript() ?>
	<script src="/themes/default/js/bootstrap.min.js"></script>
	<script src="/themes/default/js/notify.min.js"></script>
	<script src="/themes/default/js/app.js"></script>

<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover()
	});
</script>
</body>
</html>
