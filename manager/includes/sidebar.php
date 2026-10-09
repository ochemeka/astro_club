<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

 <aside class="main-sidebar">

   <!-- sidebar: style can be found in sidebar.less -->
   <section class="sidebar">

     <!-- search form (Optional) -->
     <form action="#" method="get" class="sidebar-form">
       <div class="input-group">
         <input type="text" name="q" class="form-control" placeholder="Search...">
         <span class="input-group-btn">
           <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
         </span>
       </div>
     </form>
     <!-- /.search form -->

     <!-- Sidebar Menu -->
     <ul class="sidebar-menu">
       <li class="header">MENU</li>
       <li class="<?php echo ($current_page === 'dashboard.php') ? 'active' : ''; ?>">
         <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard Home</span></a>
       </li>

       <li class="treeview <?php echo (in_array($current_page, ['manage_members.php', 'manage_edituser.php'])) ? 'active' : ''; ?>">
         <a href="#"><i class="fa fa-users"></i> <span>Manage Account</span> <i class="fa fa-angle-left pull-right"></i></a>
         <ul class="treeview-menu">
           <li class="<?php echo ($current_page === 'manage_members.php') ? 'active' : ''; ?>"><a href="manage_members.php">All Members</a></li>
         </ul>
       </li>

       <li class="treeview <?php echo (in_array($current_page, ['manage_vitals.php', 'addvital.php', 'manage_editvital.php', 'view_vital.php'])) ? 'active' : ''; ?>">
         <a href="#"><i class="fa fa-heartbeat"></i> <span>Manage Vitals</span> <i class="fa fa-angle-left pull-right"></i></a>
         <ul class="treeview-menu">
           <li class="<?php echo ($current_page === 'manage_vitals.php') ? 'active' : ''; ?>"><a href="manage_vitals.php">All Vitals</a></li>
           <li class="<?php echo ($current_page === 'addvital.php') ? 'active' : ''; ?>"><a href="addvital.php">Add Vitals</a></li>
         </ul>
       </li>

       <li class="treeview <?php echo ($current_page === 'user_vitals.php') ? 'active' : ''; ?>">
         <a href="#"><i class="fa fa-user-md"></i> <span>User Vitals</span> <i class="fa fa-angle-left pull-right"></i></a>
         <ul class="treeview-menu">
           <li class="<?php echo ($current_page === 'user_vitals.php') ? 'active' : ''; ?>"><a href="user_vitals.php">User Vitals</a></li>
         </ul>
       </li>

       <li class="<?php echo ($current_page === 'manage_changepass.php') ? 'active' : ''; ?>"><a href="manage_changepass.php"><i class="fa fa-key"></i> <span>Update Password</span></a></li>
       <li><a href="logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>

       <li><a href="../index.php"><i class="fa fa-home"></i> <span>Back to Homepage</span></a></li>
     </ul>
     <!-- /.sidebar-menu -->
   </section>
   <!-- /.sidebar -->
 </aside>
