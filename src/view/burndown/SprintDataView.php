<?php

final class SprintDataView extends SprintView
{

  private $request;
  private $timezone;
  private $timeseries;
  private $project;
  private $viewer;
  private $tasks;
  private $taskpoints;
  private $events;
  private $start;
  private $end;
  private $before;

  public function setProject($project) {
    $this->project = $project;
    return $this;
  }

  public function setViewer($viewer) {
    $this->viewer = $viewer;
    return $this;
  }

  public function setRequest($request) {
    $this->request = $request;
    return $this;
  }

  public function render() {
    $query = id(new SprintQuery())
        ->setProject($this->project)
        ->setViewer($this->viewer)
        ->setPHID($this->project->getPHID());

    $this->taskpoints = $query->getTaskData();
    $tasks = $query->getTasks();
    $this->tasks = mpull($tasks, null, 'getPHID');
    $stats = id(new SprintBuildStats());

    $this->setStartandEndDates($query);
    $this->setTimezone($stats);
    $this->setBefore($stats);
    $this->setTimeSeries($stats);
    $this->setEvents($query);

    $chart_model = id(new ChartDataProvider())
        ->setStart($this->start)
        ->setEnd($this->end)
        ->setProject($this->project)
        ->setEvents($this->events)
        ->setViewer($this->viewer)
        ->setTasks($this->tasks)
        ->setTimezone($this->timezone)
        ->setTaskPoints($this->taskpoints)
        ->setBefore($this->before)
        ->setQuery($query)
        ->setStats($stats);

    $chart_data = $chart_model->buildChartDataSet();

    $chart_view = id(new C3ChartView())
        ->setChartData($chart_data)
        ->setProject($this->project)
        ->setTimeSeries($this->timeseries);
    $chart = $chart_view->buildC3Chart();

    $tasks_table_view = id(new TasksTableView())
        ->setProject($this->project)
        ->setViewer($this->viewer)
        ->setRequest($this->request)
        ->setTasks($this->tasks)
        ->setTaskPoints($this->taskpoints)
        ->setQuery($query);
    $tasks_table = $tasks_table_view->buildTasksTable();

    $pie_chart_view = id(new C3PieView())
        ->setTasks($this->tasks)
        ->setTaskPoints($this->taskpoints)
        ->setProject($this->project);
    $pie_chart = $pie_chart_view->buildC3Pie();

    $history_table_view = new HistoryTableView();
    $history_table = $history_table_view->buildHistoryTable($this->before);

    $board_data = id(new BoardDataProvider())
        ->setProject($this->project)
        ->setViewer($this->viewer)
        ->setRequest($this->request)
        ->setTasks($this->tasks)
        ->setTaskPoints($this->taskpoints)
        ->setQuery($query);

    $board_data_table_view = id(new BoardDataView())
        ->setBoardData($board_data);
    $board_table = $board_data_table_view->buildBoardDataTable();

    // $sprint_table_view = new SprintTableView();
    // $sprint_table = $sprint_table_view->buildSprintTable($this->sprint_data,
    //    $this->before);

    $event_table_view = id(new EventTableView())
        ->setProject($this->project)
        ->setViewer($this->viewer)
        ->setRequest($this->request)
        ->setEvents($this->events)
        ->setTasks($this->tasks);
    $event_table = $event_table_view->buildEventTable(
        $this->start, $this->end);

    return array($chart, $tasks_table, $pie_chart, $history_table,
        $board_table, $event_table,);
  }

  private function setStartandEndDates($query) {
    $field_list = $query->getCustomFieldList();
    $aux_fields = $query->getAuxFields($field_list);
    $this->start = $query->getStartDate($aux_fields);
    $this->end = $query->getEndDate($aux_fields);
    return $this;
  }

  private function setBefore($stats) {
    $this->before = $stats->buildBefore($this->start, $this->timezone);
    return $this;
  }

  private function setTimezone($stats) {
    $this->timezone = $stats->setTimezone($this->viewer);
    return $this;
  }

  private function setTimeSeries($stats) {
    $this->timeseries = $stats->buildTimeSeries($this->start, $this->end);
    return $this;
  }

  private function setEvents($query) {
    $xactions = $query->getXactions($this->tasks);
    $this->events = $query->getEvents($xactions, $this->tasks);
    return $this;
  }
}
