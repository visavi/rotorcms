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
</body>
</html>
