    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../kasir_home" class="nav-link <?=  ($hal == "kasir_home") ? "active" : "" ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../kasir_nota_beli" class="nav-link <?=  ($hal == "superadmin_nota_beli") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Nota Beli
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../kasir_nota_jual" class="nav-link <?=  ($hal == "superadmin_nota_jual") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Nota Jual
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../kasir_ganti_password" class="nav-link <?= ($hal == "kasir_ganti_password") ? "active" : "" ?>">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                Ganti Password
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Log Out</p>
            </a>
          </li>
        </ul>
      </nav>