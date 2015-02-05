<?php


final class BoardDataProvider {

  private $project;
  private $viewer;
  private $request;
  private $tasks;
  private $taskpoints;
  private $query;


  public function setProject ($project) {
    $this->project = $project;
    return $this;
  }

  public function setViewer ($viewer) {
    $this->viewer = $viewer;
    return $this;
  }

  public function setRequest ($request) {
    $this->request = $request;
    return $this;
  }

  public function setTasks ($tasks) {
    $this->tasks = $tasks;
    return $this;
  }

  public function setTaskPoints ($taskpoints) {
    $this->taskpoints = $taskpoints;
    return $this;
  }

  public function setQuery ($query) {
    $this->query = $query;
    return $this;
  }

  public function buildBoardDataSet() {
    $columns = $this->query->getProjectColumns();
    $positions = $this->query->getProjectColumnPositionforTask($this->tasks, $columns);
    $task_map = array();

    foreach ($this->tasks as $task) {
      $task_phid = $task->getPHID();
      if (empty($positions[$task_phid])) {
        continue;
      }
      $position = $positions[$task_phid];
      $task_map[$position->getColumnPHID()][] = $task_phid;
    }

    foreach ($columns as $column) {
      $board_column = $this->buildColumnTasks($column, $task_map);
      $board_columns[$column->getPHID()] = $board_column;
    }

    return $board_columns;
  }

  private function buildColumnTasks($column, $task_map) {
    $task_phids = idx($task_map, $column->getPHID(), array());
    $column_tasks = array_select_keys($this->tasks, $task_phids);
    return $column_tasks;
  }

  public function getColumnName($column_phid) {
    $column = $this->query->getColumnforPHID($column_phid);
    foreach ($column as $obj) {
      $name = $obj->getDisplayName();
    }
    return $name;
  }

  public function getTaskPointsSum($tasks) {
    $points_sum = null;
    $taskpoints = mpull($this->taskpoints, null, 'getObjectPHID');
    $column_points = array_intersect_key($taskpoints, $tasks);
    if (!empty($column_points)) {
      foreach ($column_points as $key => $value) {
          $points = $value->getfieldValue();
          $points_sum += $points;
      }
      if (!isset($points_sum)) {
        $points_sum = '0';
      }
    }
    return $points_sum;
  }

}
