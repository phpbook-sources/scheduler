    
+ [About Scheduler](#about-scheduler)
+ [Composer Install](#composer-install)
+ [Scheduler Tasks Example](#scheduler-tasks-example)

### About Scheduler

- A lightweight scheduler PHP library.
- With WINDOWS this library use the Task Scheduler
- With LINUX this library use the CRONTAB

### Composer Install

	composer require phpbook/scheduler

### Scheduler Tasks Example

```php
<?php

/********************************************
 * 
 *  Scheduler Tasks Example
 * 
 * ******************************************/

$taskName = 'Send Emails'; // task name

$taskCommand = 'php ' . __DIR__ . '/send-mails.php'; // or any another command to run whatever the location of the file

$intervalMinutes = 5; // interval in minutes

\PHPBook\Scheduler\Task::register($taskName, $taskCommand, $intervalMinutes); // register the task

\PHPBook\Scheduler\Task::register($taskName, $taskCommand, $intervalMinutes); // register or update the task

\PHPBook\Scheduler\Task::remove($taskName); // remove the task by the task name

?>
```
