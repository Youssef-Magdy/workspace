<!-- HEADER -->

<header id="header">
    <div id="logo-group">

        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> <img src="img/logo-blacknwhite.png" alt="SmartAdmin"> </span>
        <!-- END LOGO PLACEHOLDER -->

    </div>

    <!-- pulled right: nav area -->
    <div class="pull-right">

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- #MOBILE -->
        <!-- Top menu profile link : this shows only when top menu is active -->
        <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
            <li class="">
                <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                    <img src="img/avatars/sunny.png" alt="John Doe" class="online" />
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="login.html" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="index.php" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->

        <!-- search mobile button (this is hidden till mobile view port) -->
        <div id="search-mobile" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
        </div>
        <!-- end search mobile button -->

        <!-- input: search field -->
        <form action="search.html" class="header-search pull-right">
            <input id="search-fld"  type="text" name="param" placeholder="Find reports and more" data-autocomplete='[
					"ActionScript",
					"AppleScript",
					"Asp",
					"BASIC",
					"C",
					"C++",
					"Clojure",
					"COBOL",
					"ColdFusion",
					"Erlang",
					"Fortran",
					"Groovy",
					"Haskell",
					"Java",
					"JavaScript",
					"Lisp",
					"Perl",
					"PHP",
					"Python",
					"Ruby",
					"Scala",
					"Scheme"]'>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
            <a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
        </form>
        <!-- end input: search field -->

        <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- end fullscreen button -->

    </div>
    <!-- end pulled right: nav area -->

</header>
<!-- END HEADER -->

<!-- Left panel : Navigation area -->
<!-- Note: This width of the aside area can be adjusted through LESS variables -->
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it -->

					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						<img src="img/avatars/sunny.png" alt="me" class="online" />
						<span>
							 john.doe
						</span>
						<i class="fa fa-angle-down"></i>
					</a>

				</span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive-->
    <nav>
        <!--
        NOTE: Notice the gaps after each icon usage <i></i>..
        Please note that these links work a bit different than
        traditional href="" links. See documentation for details.
        -->

        <ul>
            <li class="active">
                <a href="member.php?do=manage" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>

            </li>

            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">Members</span></a>
                <ul>
                    <li>
                        <a href="member.php?do=manage">Members</a>
                    </li>
                    <li>
                        <a href="member.php?do=add">Add Member</a>
                    </li>
                    <li>
                        <a href="member.php?do=old">Table Member</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">Settings</span></a>
                <ul>
                    <li>
                        <a href="#">Drinks</a>
                        <ul>
                            <li>
                                <a href="settings.php"><i class="fa fa-glass"></i>Drinks</a>
                            </li>
                            <li>
                                <a href="settings.php?do=add"><i class="fa fa-plus"></i>Add Drink</a>
                            </li>
                        </ul>
                    </li>
<!--                    <li>-->
<!--                        <a href="datatables.html">Data Tables <span class="badge inbox-badge bg-color-greenLight hidden-mobile">responsive</span></a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="jqgrid.html">Jquery Grid</a>-->
<!--                    </li>-->
                </ul>
            </li>
<!--            <li>-->
<!--                <a href="#"><i class="fa fa-lg fa-fw fa-pencil-square-o"></i> <span class="menu-item-parent">Forms</span></a>-->
<!--                <ul>-->
<!--                    <li>-->
<!--                        <a href="form-elements.html">Smart Form Elements</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="form-templates.html">Smart Form Layouts</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="validation.html">Smart Form Validation</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="bootstrap-forms.html">Bootstrap Form Elements</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="bootstrap-validator.html">Bootstrap Form Validation</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="plugins.html">Form Plugins</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="wizard.html">Wizards</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="other-editors.html">Bootstrap Editors</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="dropzone.html">Dropzone</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="image-editor.html">Image Cropping</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="ckeditor.html">CK Editor</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="#"><i class="fa fa-lg fa-fw fa-desktop"></i> <span class="menu-item-parent">UI Elements</span></a>-->
<!--                <ul>-->
<!--                    <li>-->
<!--                        <a href="general-elements.html">General Elements</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="buttons.html">Buttons</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#">Icons</a>-->
<!--                        <ul>-->
<!--                            <li>-->
<!--                                <a href="fa.html"><i class="fa fa-plane"></i> Font Awesome</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="glyph.html"><i class="glyphicon glyphicon-plane"></i> Glyph Icons</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <a href="flags.html"><i class="fa fa-flag"></i> Flags</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="grid.html">Grid</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="treeview.html">Tree View</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="nestable-list.html">Nestable Lists</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="jqui.html">JQuery UI</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="typography.html">Typography</a>-->
<!--                    </li>-->
<!---->
<!--                </ul>-->
<!--            </li>-->

        </ul>
    </nav>


    <span class="minifyme" data-action="minifyMenu">
				<i class="fa fa-arrow-circle-left hit"></i>
			</span>

</aside>
<!-- END NAVIGATION -->
