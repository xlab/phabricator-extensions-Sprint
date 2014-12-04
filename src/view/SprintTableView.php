<?php

final class SprintTableView
{

  /**
   * Format the Burndown data for display on the page.
   *
   * @returns PHUIObjectBoxView
   */
  public function buildBurnDownTable($sprint_data, $before)
  {
    $tdata = array();
    $pdata = array();

    foreach ($sprint_data as $date) {
      $tdata[] = array(
          $date->getDate(),
          $date->getYesterdayTasksRemaining() ? null : $before->getTasksForwardfromBefore(),
          $date->getTasksRemaining(),
          $date->getTasksAddedToday(),
          $date->getTasksReopenedToday(),
          $date->getTasksClosedToday(),
      );
      $pdata[] = array(
          $date->getDate(),
          $date->getYesterdayPointsRemaining() ? null : $before->getPointsForwardfromBefore(),
          $date->getPointsRemaining(),
          $date->getPointsAddedToday(),
          $date->getPointsReopenedToday(),
          $date->getPointsClosedToday(),
      );

    }

    $ttable = id(new AphrontTableView($tdata))
        ->setHeaders(
            array(
                pht('Date'),
                pht('Starting Tasks'),
                pht('Remaining Tasks'),
                pht('Tasks Added'),
                pht('Tasks Reopened'),
                pht('Tasks Closed'),
             ));
    $ptable = id(new AphrontTableView($pdata))
        ->setHeaders(
            array(
                pht('Date'),
                pht('Starting Points'),
                pht('Remaining Points'),
                pht('Points Added'),
                pht('Points Reopened'),
                pht('Points Closed'),
            ));
    $taskdata = id(new PHUIObjectBoxView())
        ->setHeaderText(pht('Tasks'))
        ->appendChild($ttable);
    $pointsdata = id(new PHUIObjectBoxView())
        ->setHeaderText(pht('Points'))
        ->appendChild($ptable);
    $box = id(new PHUIObjectBoxView())
        ->setHeaderText(pht('Data'))
        ->appendChild($taskdata)
        ->appendChild($pointsdata);
    return $box;
  }
}
