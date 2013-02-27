		<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
						<a class="brand" href="<?php echo Ciap_Url::create('index')->buildUrl() ?>">Cuploader</a>
						<div class="nav-collapse collapse navbar-responsive-collapse">
							<ul class="nav">
								<li><a href="#" onclick="uploader.getFolderActions('<?php echo $this->current_dir; ?>'); return false;"><i class="icon-wrench"></i></a></li>
								<li>
									<span class="icon-bar"></span>
								</li>
							</ul>
							<?php if(Config_Secure::can_upload()): ?>
							<?php echo Ciap::render('uploader', Array('current_dir' => $this->current_dir, 'view_type' => $this->view_type));?>
							<?php endif; ?>
							<ul class="nav pull-right">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<?php if($this->view_type == 'view_list'): ?>
											<i class="icon-th-list"></i>
										<?php else: ?>
											<i class="icon-th"></i>
										<?php endif; ?>
										<b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li><a onclick="target.setCurrentViewType('grid');" href="<?php echo Ciap_Url::create('index', Array('type' => 'grid', 'path' => $this->current_dir))->buildUrl() ?>"><i class="icon-th"></i> <?php echo Ciap_Lang::t('grid_view') ?></a></li>
										<li><a onclick="target.setCurrentViewType('list');" href="<?php echo Ciap_Url::create('index', Array('type' => 'list', 'path' => $this->current_dir))->buildUrl() ?>"><i class="icon-th-list"></i> <?php echo Ciap_Lang::t('list_view') ?></a></li>
										<li class="divider"></li>
										<li><a href="#" onclick="uploader.getAbout(); return false;"><i class="icon-info-sign"></i> <?php echo Ciap_Lang::t('about_link') ?></a></li>
									</ul>
								</li>
							</ul>
						</div><!-- /.nav-collapse -->
					</div>
				</div>
			</div>	