<?php namespace PHPBook\Scheduler;

class Task {
	
	public static function register($taskName, $taskCommand, $intervalMinutes) {

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

			//AUTO CREATE OR REPLACE
		    $cmd = 'SCHTASKS /CREATE /SC MINUTE /MO '.$intervalMinutes.' /F /TN "'.$taskName.'" /TR "'.$taskCommand.'"';

		    exec($cmd);

		} else {

			$crontabfileLocation = __DIR__ . '/' . 'crontab-temporary.txt';

			$cmd = '*/'.$intervalMinutes.' * * * * ' . $taskCommand;

			exec('crontab -l', $cronlines);

			$found = false;

			//CREATE OR REPLACE
			foreach($cronlines as $key => $cronline) {
				if (strpos($cronline, '//' . $taskName) !== false) {
		           $cronlines[$key] = $cmd . ' ' . '//' . $taskName;
		           $found = true;
		           break;
		        }
			}
			if (!$found) {
				$cronlines[] = $cmd . ' ' . '//' . $taskName;
			}

			file_put_contents($crontabfileLocation, implode(PHP_EOL, $cronlines) . PHP_EOL);

			exec('crontab ' . $crontabfileLocation);

			unlink($crontabfileLocation);

		}


	}

	public static function remove($taskName) {

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

		    $cmd = 'SCHTASKS /DELETE /TN "'.$taskName.'" /F';

		    exec($cmd);

		} else {

			$crontabfileLocation = __DIR__ . '/' . 'crontab-temporary.txt';

			exec('crontab -l', $cronlines);

			foreach($cronlines as $key => $cronline) {
				if (strpos($cronline, '//' . $taskName) !== false) {
		           unset($cronlines[$key]);
		           break;
		        }
			}

			file_put_contents($crontabfileLocation, implode(PHP_EOL, $cronlines) . PHP_EOL);

			exec('crontab ' . $crontabfileLocation);

			unlink($crontabfileLocation);

		}


	}

}
