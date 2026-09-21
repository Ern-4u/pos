    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../home_superadmin" class="nav-link <?=  ($hal == "beranda_superadmin") ? "active" : "" ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_users" class="nav-link <?=  ($hal == "superadmin_users") ? "active" : "" ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_suplier" class="nav-link <?=  ($hal == "superadmin_suplier") ? "active" : "" ?>">
              <i class="nav-icon bi bi-truck"></i>
              <p>
                Data Suplier
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_barang" class="nav-link <?=  ($hal == "superadmin_barang") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Data Barang
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_barang_konsinyasi" class="nav-link <?=  ($hal == "superadmin_barang_konsinyasi") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Data Barang Kon
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_nota_beli" class="nav-link <?=  ($hal == "superadmin_nota_beli") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Nota Beli
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_nota_jual" class="nav-link <?=  ($hal == "superadmin_nota_jual") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Nota Jual
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_nota_jual_konsinyasi" class="nav-link <?= ($hal == "superadmin_nota_jual_konsinyasi") ? "active" : "" ?>">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Nota Jual Konsinyasi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_transaksi" class="nav-link <?=  ($hal == "superadmin_transaksi") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Transaksi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_data_transaksi_jual" class="nav-link <?=  ($hal == "data_transaksi_jual") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Rekap Tran Jual
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_data_transaksi_beli" class="nav-link <?=  ($hal == "data_transaksi_beli") ? "active" : "" ?>">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Rekap Tran Beli
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../superadmin_ganti_password" class="nav-link <?= ($hal == "superadmin_ganti_password") ? "active" : "" ?>">
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