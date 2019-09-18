
<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize">
        <span class="fa fa-dedent"></span></a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
    <!-- SEARCH -->
    <!--li class="xn-search">
        <form role="form">
            <input type="text" name="search" placeholder="Search..."/>
        </form>
    </li-->
    <!-- END SEARCH -->
    <!-- POWER OFF -->
    <li class="xn-icon-button pull-right last">
        <a href="#"><span class="fa fa-power-off"></span></a>
        <ul class="xn-drop-left animated zoomIn">
            <li>
                <a href="<?php echo $settings["cms_url"]?>Account/CreateLockScreenCookie">
                    <span class="fa fa-lock"></span>Lock Screen
                </a>
            </li>
            <li>
                <a href="<?php echo $settings["cms_url"]?>Account/LogOut">
                    <span class="fa fa-sign-out"></span> Sign Out
                </a>
            </li>
        </ul>
    </li>
    <!-- END POWER OFF -->
    
</ul>
<!-- END X-NAVIGATION VERTICAL -->
