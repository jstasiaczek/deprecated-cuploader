<?php
/*Copyright (C) 2013 Jarosław Stasiaczek
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, 
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE.
 */
?>
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
								<li><span class="icon-bar"></span></li>
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
										<li><a onclick="targetObj.setCurrentViewType('grid');" href="<?php echo Ciap_Url::create('index', Array('type' => 'grid', 'path' => $this->current_dir))->buildUrl() ?>"><i class="icon-th"></i> <?php echo Ciap_Lang::t('grid_view') ?></a></li>
										<li><a onclick="targetObj.setCurrentViewType('list');" href="<?php echo Ciap_Url::create('index', Array('type' => 'list', 'path' => $this->current_dir))->buildUrl() ?>"><i class="icon-th-list"></i> <?php echo Ciap_Lang::t('list_view') ?></a></li>
										<li class="divider"></li>
										<li><a href="#" onclick="uploader.getAbout(); return false;"><i class="icon-info-sign"></i> <?php echo Ciap_Lang::t('about_link') ?></a></li>
									</ul>
								</li>
							</ul>
						</div><!-- /.nav-collapse -->
					</div>
				</div>
			</div>	