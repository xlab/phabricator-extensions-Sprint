<?php

final class SprintProjectDetailsProfilePanel
    extends PhabricatorProfilePanel {

  const PANEL_PROFILE = 'sprint.profile';
  const PANELKEY = 'sprint.details';

  public function getPanelTypeName() {
    return pht('Sprint Details');
  }

  private function getDefaultName() {
    return pht('Sprint Details');
  }

  public function getDisplayName(
      PhabricatorProfilePanelConfiguration $config) {
    $name = $config->getPanelProperty('name');

    if (strlen($name)) {
      return $name;
    }

    return $this->getDefaultName();
  }

  public function buildEditEngineFields(
      PhabricatorProfilePanelConfiguration $config) {
    return array(
        id(new PhabricatorTextEditField())
            ->setKey('name')
            ->setLabel(pht('Name'))
            ->setPlaceholder($this->getDefaultName())
            ->setValue($config->getPanelProperty('name')),
    );
  }

  protected function newNavigationMenuItems(
      PhabricatorProfilePanelConfiguration $config) {

    $project = $config->getProfileObject();

    $id = $project->getID();
    $picture = $project->getProfileImageURI();
    $name = $project->getName();

    $href = "/project/sprint/profile/{$id}/";

    $item = $this->newItem()
        ->setHref($href)
        ->setName($name)
        ->setProfileImage($picture);

    return array(
        $item,
    );
  }

}
