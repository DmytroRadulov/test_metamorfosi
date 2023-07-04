<?php

class TaskList {
    private $tasksFile;

    public function __construct($tasksFile) {
        $this->tasksFile = $tasksFile;
    }

    public function addTask($taskName, $priority) {
        $task = array(
            'name' => $taskName,
            'priority' => $priority,
            'completed' => false
        );

        $tasks = $this->loadTasks();
        $tasks[] = $task;
        $this->saveTasks($tasks);
    }

    public function deleteTask($taskId) {
        $tasks = $this->loadTasks();
        unset($tasks[$taskId]);
        $this->saveTasks($tasks);
    }

    public function getTasks() {
        $tasks = $this->loadTasks();
        usort($tasks, function($a, $b) {
            return $b['priority'] - $a['priority'];
        });
        return $tasks;
    }

    public function completeTask($taskId) {
        $tasks = $this->loadTasks();
        if (isset($tasks[$taskId])) {
            $tasks[$taskId]['completed'] = true;
            $this->saveTasks($tasks);
        }
    }

    private function loadTasks() {
        if (file_exists($this->tasksFile)) {
            $tasksData = file_get_contents($this->tasksFile);
            return json_decode($tasksData, true);
        }
        return array();
    }

    private function saveTasks($tasks) {
        $tasksData = json_encode($tasks);
        file_put_contents($this->tasksFile, $tasksData);
    }
}


$taskList = new TaskList("tasks.json");

$taskList->addTask("task 1", 2);
$taskList->addTask("task 2", 1);
$taskList->addTask("task 3", 3);

$tasks = $taskList->getTasks();
foreach ($tasks as $task) {
    echo $task['name'] . " (Priority: " . $task['priority'] . ")" . PHP_EOL;
}

$taskList->completeTask(1);

$taskList->deleteTask(0);

$tasks = $taskList->getTasks();
foreach ($tasks as $task) {
    echo $task['name'] . " (Priority: " . $task['priority'] . ")" . PHP_EOL;
}
