<div class="nano">
	<div class="nano-content">
		<nav id="menu" class="nav-main" role="navigation">
			<ul class="nav nav-main">
				<li>
					<a href="{{ url('/main') }}">
						<i class="fa fa-home" aria-hidden="true"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<!-- <li>
					<a href="mailbox-folder.html">
						<span class="pull-right label label-primary">182</span>
						<i class="fa fa-envelope" aria-hidden="true"></i>
						<span>Mailbox</span>
					</a>
				</li> -->
				<li class="nav-parent">
					<a>
						<i class="fa fa-database" aria-hidden="true"></i>
						<span>Data Manager</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="{{ url('/updateMDC') }}">
								 Update MDC Branch Table
							</a>
						</li>
						<li>
							<a href="#">
								 Update Territory Table
							</a>
						</li>
						<li>
							<a href="#">
								 Update Doctor Table
							</a>
						</li>
						<li>
							<a href="#">
								 Update Product Table
							</a>
						</li>
						<li>
							<a href="#">
								 Upload Monthly Data
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="mailbox-folder.html">
						<!-- <span class="pull-right label label-primary">182</span> -->
						<i class="fa fa-search-plus" aria-hidden="true"></i>
						<span>Data Analysis</span>
					</a>
				</li>
				<!-- <li class="nav-parent">
					<a>
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>UI Elements</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="ui-elements-typography.html">
								 Typography
							</a>
						</li>
						<li>
							<a href="ui-elements-icons.html">
								 Icons
							</a>
						</li>
						<li>
							<a href="ui-elements-tabs.html">
								 Tabs
							</a>
						</li>
						<li>
							<a href="ui-elements-panels.html">
								 Panels
							</a>
						</li>
						<li>
							<a href="ui-elements-widgets.html">
								 Widgets
							</a>
						</li>
						<li>
							<a href="ui-elements-portlets.html">
								 Portlets
							</a>
						</li>
						<li>
							<a href="ui-elements-buttons.html">
								 Buttons
							</a>
						</li>
						<li>
							<a href="ui-elements-alerts.html">
								 Alerts
							</a>
						</li>
						<li>
							<a href="ui-elements-notifications.html">
								 Notifications
							</a>
						</li>
						<li>
							<a href="ui-elements-modals.html">
								 Modals
							</a>
						</li>
						<li>
							<a href="ui-elements-lightbox.html">
								 Lightbox
							</a>
						</li>
						<li>
							<a href="ui-elements-progressbars.html">
								 Progress Bars
							</a>
						</li>
						<li>
							<a href="ui-elements-sliders.html">
								 Sliders
							</a>
						</li>
						<li>
							<a href="ui-elements-carousels.html">
								 Carousels
							</a>
						</li>
						<li>
							<a href="ui-elements-accordions.html">
								 Accordions
							</a>
						</li>
						<li>
							<a href="ui-elements-nestable.html">
								 Nestable
							</a>
						</li>
						<li>
							<a href="ui-elements-tree-view.html">
								 Tree View
							</a>
						</li>
						<li>
							<a href="ui-elements-grid-system.html">
								 Grid System
							</a>
						</li>
						<li>
							<a href="ui-elements-charts.html">
								 Charts
							</a>
						</li>
						<li>
							<a href="ui-elements-animations.html">
								 Animations
							</a>
						</li>
						<li>
							<a href="ui-elements-extra.html">
								 Extra
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-parent">
					<a>
						<i class="fa fa-list-alt" aria-hidden="true"></i>
						<span>Forms</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="forms-basic.html">
								 Basic
							</a>
						</li>
						<li>
							<a href="forms-advanced.html">
								 Advanced
							</a>
						</li>
						<li>
							<a href="forms-validation.html">
								 Validation
							</a>
						</li>
						<li>
							<a href="forms-layouts.html">
								 Layouts
							</a>
						</li>
						<li>
							<a href="forms-wizard.html">
								 Wizard
							</a>
						</li>
						<li>
							<a href="forms-code-editor.html">
								 Code Editor
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-parent">
					<a>
						<i class="fa fa-table" aria-hidden="true"></i>
						<span>Tables</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="tables-basic.html">
								 Basic
							</a>
						</li>
						<li>
							<a href="tables-advanced.html">
								 Advanced
							</a>
						</li>
						<li>
							<a href="tables-responsive.html">
								 Responsive
							</a>
						</li>
						<li>
							<a href="tables-editable.html">
								 Editable
							</a>
						</li>
						<li>
							<a href="tables-ajax.html">
								 Ajax
							</a>
						</li>
						<li>
							<a href="tables-pricing.html">
								 Pricing
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-parent">
					<a>
						<i class="fa fa-map-marker" aria-hidden="true"></i>
						<span>Maps</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="maps-google-maps.html">
								 Basic
							</a>
						</li>
						<li>
							<a href="maps-google-maps-builder.html">
								 Map Builder
							</a>
						</li>
						<li>
							<a href="maps-vector.html">
								 Vector
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-parent">
					<a>
						<i class="fa fa-columns" aria-hidden="true"></i>
						<span>Layouts</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a href="layouts-default.html">
								 Default
							</a>
						</li>
						<li>
							<a href="layouts-boxed.html">
								 Boxed
							</a>
						</li>
						<li>
							<a href="layouts-menu-collapsed.html">
								 Menu Collapsed
							</a>
						</li>
						<li>
							<a href="layouts-scroll.html">
								 Scroll
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-parent">
					<a>
						<i class="fa fa-align-left" aria-hidden="true"></i>
						<span>Menu Levels</span>
					</a>
					<ul class="nav nav-children">
						<li>
							<a>First Level</a>
						</li>
						<li class="nav-parent">
							<a>Second Level</a>
							<ul class="nav nav-children">
								<li class="nav-parent">
									<a>Third Level</a>
									<ul class="nav nav-children">
										<li>
											<a>Third Level Link #1</a>
										</li>
										<li>
											<a>Third Level Link #2</a>
										</li>
									</ul>
								</li>
								<li>
									<a>Second Level Link #1</a>
								</li>
								<li>
									<a>Second Level Link #2</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<li>
					<a href="http://themeforest.net/item/JSOFT-responsive-html5-template/4106987?ref=JSOFT" target="_blank">
						<i class="fa fa-external-link" aria-hidden="true"></i>
						<span>Front-End <em class="not-included">(Not Included)</em></span>
					</a>
				</li> -->
			</ul>
		</nav>

		<hr class="separator" />

		<!-- <div class="sidebar-widget widget-tasks">
			<div class="widget-header">
				<h6>Projects</h6>
				<div class="widget-toggle">+</div>
			</div>
			<div class="widget-content">
				<ul class="list-unstyled m-none">
					<li><a href="#">JSOFT HTML5 Template</a></li>
					<li><a href="#">Tucson Template</a></li>
					<li><a href="#">JSOFT Admin</a></li>
				</ul>
			</div>
		</div>

		<hr class="separator" />

		<div class="sidebar-widget widget-stats">
			<div class="widget-header">
				<h6>Company Stats</h6>
				<div class="widget-toggle">+</div>
			</div>
			<div class="widget-content">
				<ul>
					<li>
						<span class="stats-title">Stat 1</span>
						<span class="stats-complete">85%</span>
						<div class="progress">
							<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
								<span class="sr-only">85% Complete</span>
							</div>
						</div>
					</li>
					<li>
						<span class="stats-title">Stat 2</span>
						<span class="stats-complete">70%</span>
						<div class="progress">
							<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
								<span class="sr-only">70% Complete</span>
							</div>
						</div>
					</li>
					<li>
						<span class="stats-title">Stat 3</span>
						<span class="stats-complete">2%</span>
						<div class="progress">
							<div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
								<span class="sr-only">2% Complete</span>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div> -->
	</div>

</div>