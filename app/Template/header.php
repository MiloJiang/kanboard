<header>
    <nav>
        <h1>
            <span class="logo">
                <?= $this->url->link('K<span>B</span>', 'DashboardController', 'show', array(), false, '', t('Dashboard')) ?>
            </span>
            <span class="title">
                <?php if (! empty($project) && ! empty($task)): ?>
                    <?= $this->url->link($this->text->e($project['name']), 'BoardViewController', 'show', array('project_id' => $project['id'])) ?>
                <?php else: ?>
                    <?= $this->text->e($title) ?>
                <?php endif ?>
            </span>
            <?php if (! empty($description)): ?>
                <span class="tooltip" title="<?= $this->text->markdownAttribute($description) ?>">
                    <i class="fa fa-info-circle"></i>
                </span>
            <?php endif ?>
        </h1>
        <ul>
            <?php if (isset($board_selector) && ! empty($board_selector)): ?>
            <li>
                <select id="board-selector"
                        class="chosen-select select-auto-redirect"
                        tabindex="-1"
                        data-search-threshold="0"
                        data-notfound="<?= t('No results match:') ?>"
                        data-placeholder="<?= t('Display another project') ?>"
                        data-redirect-regex="PROJECT_ID"
                        data-redirect-url="<?= $this->url->href('BoardViewController', 'show', array('project_id' => 'PROJECT_ID')) ?>">
                    <option value=""></option>
                    <?php foreach ($board_selector as $board_id => $board_name): ?>
                        <option value="<?= $board_id ?>"><?= $this->text->e($board_name) ?></option>
                    <?php endforeach ?>
                </select>
            </li>
            <?php endif ?>
            <li class="user-links">
                <?php if ($this->user->hasNotifications()): ?>
                    <span class="notification">
                        <?= $this->url->link('<i class="fa fa-bell web-notification-icon"></i>', 'DashboardController', 'notifications', array('user_id' => $this->user->getId()), false, '', t('Unread notifications')) ?>
                    </span>
                <?php endif ?>

                <?php $has_project_creation_access = $this->user->hasAccess('ProjectCreationController', 'create'); ?>
                <?php $is_private_project_enabled = $this->app->config('disable_private_project', 0) == 0; ?>

                <?php if ($has_project_creation_access || (!$has_project_creation_access && $is_private_project_enabled)): ?>
                <div class="dropdown">
                    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-plus fa-fw"></i><i class="fa fa-caret-down"></i></a>
                    <ul>
                        <?php if ($has_project_creation_access): ?>
                            <li><i class="fa fa-plus fa-fw"></i>
                            <?= $this->url->link(t('New project'), 'ProjectCreationController', 'create', array(), false, 'popover') ?></li>
                        <?php endif ?>
                        <?php if ($is_private_project_enabled): ?>
                        <li>
                            <i class="fa fa-lock fa-fw"></i>
                            <?= $this->url->link(t('New private project'), 'ProjectCreationController', 'createPrivate', array(), false, 'popover') ?>
                        </li>
                        <?php endif ?>
                        <?= $this->hook->render('template:header:creation-dropdown') ?>
                    </ul>
                </div>
                <?php endif ?>

                <div class="dropdown">
                    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><?= $this->avatar->currentUserSmall('avatar-inline') ?><i class="fa fa-caret-down"></i></a>
                    <ul>
                        <li class="no-hover"><strong><?= $this->text->e($this->user->getFullname()) ?></strong></li>
                        <li>
                            <i class="fa fa-tachometer fa-fw"></i>
                            <?= $this->url->link(t('My dashboard'), 'DashboardController', 'show', array('user_id' => $this->user->getId())) ?>
                        </li>
                        <li>
                            <i class="fa fa-home fa-fw"></i>
                            <?= $this->url->link(t('My profile'), 'UserViewController', 'show', array('user_id' => $this->user->getId())) ?>
                        </li>
                        <li>
                            <i class="fa fa-folder fa-fw"></i>
                            <?= $this->url->link(t('Projects management'), 'ProjectListController', 'show') ?>
                        </li>
                        <?php if ($this->user->hasAccess('UserListController', 'show')): ?>
                            <li>
                                <i class="fa fa-user fa-fw"></i>
                                <?= $this->url->link(t('Users management'), 'UserListController', 'show') ?>
                            </li>
                            <li>
                                <i class="fa fa-group fa-fw"></i>
                                <?= $this->url->link(t('Groups management'), 'GroupListController', 'index') ?>
                            </li>
                            <li>
                                <i class="fa fa-cubes" aria-hidden="true"></i>
                                <?= $this->url->link(t('Plugins'), 'PluginController', 'show') ?>
                            </li>
                            <li>
                                <i class="fa fa-cog fa-fw"></i>
                                <?= $this->url->link(t('Settings'), 'ConfigController', 'index') ?>
                            </li>
                        <?php endif ?>

                        <?= $this->hook->render('template:header:dropdown') ?>

                        <li>
                            <i class="fa fa-life-ring fa-fw"></i>
                            <?= $this->url->link(t('Documentation'), 'DocumentationController', 'show') ?>
                        </li>
                        <?php if (! DISABLE_LOGOUT): ?>
                            <li>
                                <i class="fa fa-sign-out fa-fw"></i>
                                <?= $this->url->link(t('Logout'), 'AuthController', 'logout') ?>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</header>
