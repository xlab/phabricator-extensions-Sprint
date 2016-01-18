<?php

abstract class SprintBoardController
  extends SprintProjectController {

  private $project;

  protected function setProject(PhabricatorProject $project) {
    $this->project = $project;
    return $this;
  }
  protected function getProject() {
    return $this->project;
  }

  protected function getProfileMenu() {
    $menu = parent::getProfileMenu();

    $menu->selectFilter(PhabricatorProject::PANEL_WORKBOARD);
    $menu->addClass('project-board-nav');

    return $menu;
  }
}
