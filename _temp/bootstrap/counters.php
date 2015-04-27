<?php
#---------------------------------------------#
#      ********* RotorCMS *********           #
#           Author  :  Vantuz                 #
#            Email  :  visavi.net@mail.ru     #
#             Site  :  http://visavi.net      #
#              ICQ  :  36-44-66               #
#            Skype  :  vantuzilla             #
#---------------------------------------------#
if (!defined('BASEDIR')) {
	header('Location: /index.php');
	exit;
}

$days = floor((gmmktime(0, 0, 0, date("m"), date("d"), date("Y")) - gmmktime(0, 0, 0, 1, 1, 1970)) / 86400);
$hours = floor((gmmktime(date("H"), 0, 0, date("m"), date("d"), date("Y")) - gmmktime((date("Z") / 3600), 0, 0, 1, 1, 1970)) / 3600);

Online::delete_all(array('conditions' => 'created_at < NOW() - INTERVAL 10 MINUTE'));

$online = stats_online();
if ($online[1] < 150 || is_user()) {
	$newhost = 0;

	if (is_user()) {

		$online = Online::first(array('conditions' => array('user_id = ? OR ip = ?', $current_user->id, $ip)));
		//$queryonline = DB::run() -> querySingle("SELECT `online_id` FROM `online` WHERE `online_ip`=? OR `online_user`=? LIMIT 1;", array($ip, $log));
		if ($online) {

			$online->user_id = $current_user->id;
			$online->ip = $ip;
			$online->brow = $brow;
			$online->save();

			//DB::run() -> query("UPDATE `online` SET `online_ip`=?, `online_brow`=?, `online_time`=?, `online_user`=? WHERE `online_id`=? LIMIT 1;", array($ip, $brow, SITETIME, $log, $queryonline));

		} else {

			$attributes = array(
				'user_id' => $current_user->id,
				'ip' => $ip,
				'brow' => $brow
			);
			Online::create($attributes);

			//DB::run() -> query("INSERT INTO `online` (`online_ip`, `online_brow`, `online_time`, `online_user`) VALUES (?, ?, ?, ?);", array($ip, $brow, SITETIME, $log));
			$newhost = 1;
		}


	} else {
		//$queryonline = DB::run() -> querySingle("SELECT `online_id` FROM `online` WHERE `online_ip`=? LIMIT 1;", array($ip));

		$online = Online::first(array('conditions' => array('ip = ?', $ip)));

		if ($online) {

			$online->ip = $ip;
			$online->brow = $brow;
			$online->save();

			//DB::run() -> query("UPDATE `online` SET `online_brow`=?, `online_time`=?, `online_user`=? WHERE `online_id`=? LIMIT 1;", array($brow, SITETIME, '', $queryonline));
		} else {

			$attributes = array(
				'ip' => $ip,
				'brow' => $brow
			);
			Online::create($attributes);

			//DB::run() -> query("INSERT INTO `online` (`online_ip`, `online_brow`, `online_time`) VALUES (?, ?, ?);", array($ip, $brow, SITETIME));
			$newhost = 1;
		}
	}
	// -----------------------------------------------------------//
	$count = Counter::first();

	//$count = DB::run() -> queryFetch("SELECT * FROM `counter`;");

	if ($count->hours != $hours) {

		$counter24 = Counter24::find_by_hour($hours) ?: new Counter24;
		$counter24->hour = $hours;
		$counter24->hosts = $count->hosts24;
		$counter24->hits = $count->hits24;
		$counter24->save();

		$count->hours = $hours;
		$count->hosts24 = 0;
		$count->hits24 = 0;
		$count->save();

		$clocks = Counter24::all(array('offset' => 24, 'limit' => 10, 'order' => 'hour desc'));
		$delete = ActiveRecord\collect($clocks, 'id');
		if ($delete) Counter24::table()->delete(array('id' => array($delete)));


		//DB::run() -> query("INSERT IGNORE INTO `counter24` (`count_hour`, `count_hosts`, `count_hits`) VALUES (?, ?, ?);", array($hours, $counts['count_hosts24'], $counts['count_hits24']));
		//DB::run() -> query("UPDATE `counter` SET `count_hours`=?, `count_hosts24`=?, `count_hits24`=?;", array($hours, 0, 0));
		//DB::run() -> query("DELETE FROM `counter24` WHERE `count_hour` < (SELECT MIN(`count_hour`) FROM (SELECT `count_hour` FROM `counter24` ORDER BY `count_hour` DESC LIMIT 24) AS del);");

	}

	if ($count->days != $days) {

		$counter31 = Counter31::find_by_day($days) ?: new Counter31;
		$counter31->day = $days;
		$counter31->hosts = $count->dayhosts;
		$counter31->hits = $count->dayhits;
		$counter31->save();

		$count->days = $days;
		$count->dayhosts = 0;
		$count->dayhits = 0;
		$count->save();

		$days31 = Counter31::all(array('offset' => 31, 'limit' => 10, 'order' => 'day desc'));
		$delete = ActiveRecord\collect($days31, 'id');
		if ($delete) Counter31::table()->delete(array('id' => array($delete)));


		$counter7 = Counter31::all(array('limit' => 6, 'order' => 'day desc'));
		$weeks = ActiveRecord\assoc($counter7, 'day', 'hosts');

		$host_data = array();
		for ($i = 0, $tekdays = $days; $i < 6; $tekdays--, $i++) {
			array_unshift($host_data, (isset($weeks[$tekdays])) ? $weeks[$tekdays] : 0);
		}

		file_put_contents(STORAGE.'/temp/counter7.dat', serialize($host_data), LOCK_EX);

		//
		/*
		DB::run() -> query("INSERT IGNORE INTO `counter31` (`count_days`, `count_hosts`, `count_hits`) VALUES (?, ?, ?);", array($days, $counts['count_dayhosts'], $counts['count_dayhits']));
		DB::run() -> query("UPDATE `counter` SET `count_days`=?, `count_dayhosts`=?, `count_dayhits`=?;", array($days, 0, 0));
		DB::run() -> query("DELETE FROM `counter31` WHERE `count_days` < (SELECT MIN(`count_days`) FROM (SELECT `count_days` FROM `counter31` ORDER BY `count_days` DESC LIMIT 31) AS del);");
		// ---------------------------------------------------//
		$querycount = DB::run() -> query("SELECT `count_days`, `count_hosts` FROM `counter31` ORDER BY `count_days` DESC LIMIT 6;");
		$counts = $querycount -> fetchAssoc();

		$host_data = array();
		for ($i = 0, $tekdays = $days; $i < 6; $tekdays--, $i++) {
			array_unshift($host_data, (isset($counts[$tekdays])) ? $counts[$tekdays] : 0);
		}

		file_put_contents(STORAGE.'/temp/counter7.dat', serialize($host_data), LOCK_EX);
		*/
	}
	// -----------------------------------------------------------//
	$counter = Counter::first();

	if ($newhost) {
		$counter->allhosts = $counter->allhosts + 1;
		$counter->dayhosts = $counter->dayhosts + 1;
		$counter->hosts24 = $counter->hosts24 + 1;
	}

	$counter->allhits = $counter->allhits + 1;
	$counter->dayhits = $counter->dayhits + 1;
	$counter->hits24 = $counter->hits24 + 1;
	$counter->save();
}

?>
