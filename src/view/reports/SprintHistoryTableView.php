<?php

final class SprintHistoryTableView {

  private $tableData;

  public function setTableData ($table_data) {
    $this->tableData = $table_data;
    return $this;
  }

  public function buildProjectsTable () {
    $id = 'history-table';
    Javelin::initBehavior('sprint-history-table', array(
        'hardpoint' => $id,
    ), 'sprint');
    $projects_table = id(new SprintTableView($this->tableData->getRows()))
        ->setHeaders(
            array(
                'projectremoved',
                'projectadded',
                'projName',
                'taskName',
                'createdEpoch',
                'created',
            ))
        ->setTableId('sprint-history')
        ->setClassName('display');

    $projects_table = id(new PHUIBoxView())
        ->appendChild($projects_table)
        ->addMargin(PHUI::MARGIN_LARGE);

    return $projects_table;
  }

}
