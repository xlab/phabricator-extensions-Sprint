<?php

function init_phabricator_script() {

  phutil_load_library('/srv/phabricator/libphutil/src');
  phutil_load_library('/srv/phabricator/phabricator/src');
  phutil_load_library('/srv/phabricator/libext/sprint/src');
  phutil_load_library('/srv/phabricator/arcanist/src');


  PhabricatorEnv::initializeScriptEnvironment();
}

init_phabricator_script();
