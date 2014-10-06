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
				<?= navigation() ?>
				<?= perfomance() ?>
		</div>
	</div>

	<?= include_javascript() ?>
	<script src="/themes/bootstrap/js/bootstrap.min.js"></script>
	<script src="/themes/bootstrap/js/app.js"></script>

<script type="text/javascript">
	$(function () {
		$("[data-toggle='tooltip']").tooltip();
	});
</script>
</body>
</html>
