<?php

final class SprintHistoryController extends SprintController {

  private $view;
  private $viewer;

  public function handleRequest(AphrontRequest $request) {
    $this->viewer = $request->getUser();

    $error_box = null;
    $history_model = id(new SprintHistoryDataProvider())
        ->setViewer($this->viewer)
        ->setRequest($request)
        ->execute();

    try {
      $sprintlist_table = id(new SprintHistoryTableView())
          ->setTableData($history_model)
          ->buildProjectsTable();
    } catch (Exception $e) {
      $error_box = $this->getErrorBox($e);
    }


    $can_create = $this->hasApplicationCapability(
        ProjectCreateProjectsCapability::CAPABILITY);
    $crumbs = $this->buildSprintApplicationCrumbs($can_create);
    $crumbs->addTextCrumb(pht('Sprint Burndown List'));

    $help = id(new PHUIBoxView())
        ->appendChild(phutil_tag('p', array(),
            'This is a history of all tasks and logs when a project was added or removed'))
        ->addMargin(PHUI::MARGIN_LARGE);
    $nav = $this->buildNavMenu();
    $this->view = $nav->selectFilter($this->view, 'history');
    $nav->appendChild(
        array(
            $error_box,
            $crumbs,
            $help,
            $sprintlist_table,
        ));

    return $this->buildApplicationPage(
        $nav,
        array(
            'title' => array(pht('Sprint List')),
            'device' => true,
        ));
  }
}
