<?php
/**
 * @author Michael Peters
 * @license GPL version 3
 */

final class SprintApplication extends PhabricatorApplication {

  public function getName() {
    return pht('Sprint');
  }

  public function getBaseURI()
  {
      return '/project/sprint/';
  }

  public function getIconName() {
    return 'fa-puzzle-piece';
  }

  public function getShortDescription() {
    return 'Build Sprints';
  }

  public function getEventListeners() {
    return array(
      new BurndownActionMenuEventListener(),
    );
  }

  public function getFactObjectsForAnalysis() {
    return array(
        new ManiphestTransaction(),
    );
  }

  public function getRoutes() {

    return array(
            // this is the default application route controller
          '/project/sprint/' => array(
              '' => 'SprintListController',
<<<<<<< HEAD
            // these are forked controllers for the Sprint Board
=======
              'report/' => 'SprintListController',
              'report/list/' => 'SprintListController',
              'report/(?:(?P<view>\w+)/)?' => 'SprintReportController',
              'view/(?P<id>\d+)/' => 'SprintDataViewController',
              'details/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectEditDetailsController',
              'archive/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectArchiveController',
              'members/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectMembersEditController',
              'members/(?P<id>[1-9]\d*)/remove/'
              => 'PhabricatorProjectMembersRemoveController',
              'move/(?P<id>[1-9]\d*)/' => 'SprintBoardMoveController',
              'picture/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectEditPictureController',
              'profile/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectProfileController',
              'icon/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectEditIconController',
              'board/task/edit/(?P<id>[1-9]\d*)/'
              =>  'SprintBoardTaskEditController',
              'board/task/create/'
              => 'SprintBoardTaskEditController',
              'board/(?P<id>[1-9]\d*)/' .
              '(?P<filter>filter/)?' .
              '(?:query/(?P<queryKey>[^/]+)/)?'
              => 'SprintBoardViewController',
>>>>>>> d1cf93f00fd019cf2f0d191e99637b63f5a1cf50
              'board/(?P<projectID>[1-9]\d*)/' => array(
                  'edit/(?:(?P<id>\d+)/)?'
                  => 'SprintBoardColumnEditController',
                  'hide/(?:(?P<id>\d+)/)?'
                  => 'SprintBoardColumnHideController',
                  'column/(?:(?P<id>\d+)/)?'
                  => 'SprintBoardColumnDetailController',
                  'import/'
                  => 'SprintBoardImportController',
                  'reorder/'
                  => 'SprintBoardReorderController',
              ),
            // these allow task creation and editing from a Sprint Board
              'board/task/edit/(?P<id>[1-9]\d*)/'
              => 'SprintBoardTaskEditController',
              'board/task/create/'
              => 'SprintBoardTaskEditController',
            // these are for board filters and column queries
              'board/(?P<id>[1-9]\d*)/'.
              '(?P<filter>filter/)?'.
              '(?:query/(?P<queryKey>[^/]+)/)?'
              => 'SprintBoardViewController',
            // these are native Sprint application controllers
              'burn/(?P<id>\d+)/' => 'SprintDataViewController',
              'profile/(?P<id>[1-9]\d*)/'
              => 'SprintProjectProfileController',
              'report/list/' => 'SprintListController',
              'report/(?:(?P<view>\w+)/)?' => 'SprintReportController',
              'view/(?P<id>\d+)/' => 'SprintDataViewController',
              // all routes following point to default controllers
              'archive/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectArchiveController',
              'details/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectEditDetailsController',
              'feed/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectFeedController',
              'icon/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectEditIconController',
              'members/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectMembersEditController',
              'members/(?P<id>[1-9]\d*)/remove/'
              => 'PhabricatorProjectMembersRemoveController',
              'move/(?P<id>[1-9]\d*)/' => 'SprintBoardMoveController',
              'picture/(?P<id>[1-9]\d*)/'
              => 'PhabricatorProjectEditPictureController',
              'update/(?P<id>[1-9]\d*)/(?P<action>[^/]+)/'
              => 'PhabricatorProjectUpdateController',
          ),
          // primary tag route override
          '/tag/' => array(
              '(?P<slug>[^/]+)/' => 'SprintBoardViewController',
              '(?P<slug>[^/]+)/board/' => 'SprintBoardViewController',
          ),
          '/project/' => array(
              'sboard/(?P<id>[1-9]\d*)/'.
              '(?P<filter>filter/)?'.
              '(?:query/(?P<queryKey>[^/]+)/)?'
              => 'SprintBoardViewController',
              'burn/(?P<id>\d+)/' => 'SprintDataViewController',
              ),
      );
  }

  protected function getCustomCapabilities() {
    return array(
        SprintDefaultViewCapability::CAPABILITY => array(
            'caption' => pht(
                'Default view policy for newly created sprints.'),
        ),
        ProjectCreateProjectsCapability::CAPABILITY => array(),
        ProjectCanLockProjectsCapability::CAPABILITY => array(
            'default' => PhabricatorPolicies::POLICY_ADMIN,
        ),
        ManiphestDefaultViewCapability::CAPABILITY => array(
            'caption' => pht('Default view policy for newly created tasks.'),
        ),
        ManiphestDefaultEditCapability::CAPABILITY => array(
            'caption' => pht('Default edit policy for newly created tasks.'),
        ),
        ManiphestEditStatusCapability::CAPABILITY => array(),
        ManiphestEditAssignCapability::CAPABILITY => array(),
        ManiphestEditPoliciesCapability::CAPABILITY => array(),
        ManiphestEditPriorityCapability::CAPABILITY => array(),
        ManiphestEditProjectsCapability::CAPABILITY => array(),
    );
  }
}
